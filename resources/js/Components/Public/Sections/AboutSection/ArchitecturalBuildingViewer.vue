<script setup>
import { ref, onMounted, onBeforeUnmount, watch } from 'vue';
import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader.js';

const props = defineProps({
    modelUrl: {
        type: String,
        default: ''
    },
    currentStage: {
        type: Number,
        default: 4 // 1: Foundation, 2: Structure, 3: Enclosure, 4: Completed
    },
    autoProgress: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['stage-change', 'scene-ready']);

const containerRef = ref(null);
const webGlSupported = ref(true);
const isLoading = ref(true);
const activeStageIndex = ref(props.currentStage);
const isUserDragging = ref(false);

// Three.js State
let scene, camera, renderer, animationFrameId;
let buildingGroup, customModelGroup;
let stageGroups = {
    foundation: null,
    columns: null,
    slabs: null,
    walls: null,
    windows: null,
    roof: null,
    finishes: null
};

// Parallax, 360° Mouse/Touch Drag & Scroll Tracking
let mouse = { x: 0, y: 0, targetX: 0, targetY: 0 };
let isDragging = false;
let previousPointerPos = { x: 0, y: 0 };
let userRotationY = 0;
let targetUserRotationY = 0;
let userRotationX = 0;
let targetUserRotationX = 0;

let scrollFactor = 0;
let scrollDrivenRotation = 0;
let targetScrollDrivenRotation = 0;
let isVisible = true;
let intersectionObserver = null;
let resizeObserver = null;

// Materials Palette - Realistic Architectural Finishes
let materials = {};

const initMaterials = () => {
    // Cast-in-place Architectural Concrete
    materials.concrete = new THREE.MeshStandardMaterial({
        color: 0x94989e,
        roughness: 0.82,
        metalness: 0.05,
        flatShading: false,
    });

    materials.darkConcrete = new THREE.MeshStandardMaterial({
        color: 0x3d4148,
        roughness: 0.88,
        metalness: 0.1,
    });

    // Rebar / Steel Columns
    materials.steel = new THREE.MeshStandardMaterial({
        color: 0x1f242d,
        roughness: 0.35,
        metalness: 0.85,
    });

    materials.accentSteel = new THREE.MeshStandardMaterial({
        color: 0xf59e0b, // Amber architectural steel accent
        roughness: 0.4,
        metalness: 0.6,
    });

    // Modern Double-Glazed Architectural Glass (Subtle Tint & Reflective)
    materials.glass = new THREE.MeshPhysicalMaterial({
        color: 0xa0bed8,
        metalness: 0.1,
        roughness: 0.1,
        transmission: 0.68,
        transparent: true,
        opacity: 0.75,
        ior: 1.52,
        reflectivity: 0.55,
    });

    // Facade Louvers / Warm Timber Accents
    materials.woodLouver = new THREE.MeshStandardMaterial({
        color: 0xb47946,
        roughness: 0.65,
        metalness: 0.05,
    });

    // Interior Warm Core
    materials.interior = new THREE.MeshStandardMaterial({
        color: 0x1a1e28,
        roughness: 0.9,
        metalness: 0.0,
    });

    // Floor Slab Edges
    materials.slabEdge = new THREE.MeshStandardMaterial({
        color: 0x64748b,
        roughness: 0.75,
        metalness: 0.15,
    });
};

const checkWebGL = () => {
    try {
        const canvas = document.createElement('canvas');
        return !!(window.WebGLRenderingContext && (canvas.getContext('webgl') || canvas.getContext('experimental-webgl')));
    } catch (e) {
        return false;
    }
};

const buildArchitecturalStructure = () => {
    buildingGroup = new THREE.Group();
    buildingGroup.name = 'ProceduralArchitecturalBuilding';

    // 1. STAGE: FOUNDATION & GROUND GRID
    stageGroups.foundation = new THREE.Group();
    stageGroups.foundation.name = 'Stage_Foundation';

    // Ground Excavation Base Plate
    const basePlateGeo = new THREE.BoxGeometry(22, 0.4, 18);
    const basePlate = new THREE.Mesh(basePlateGeo, materials.darkConcrete);
    basePlate.position.set(0, -0.2, 0);
    basePlate.receiveShadow = true;
    stageGroups.foundation.add(basePlate);

    // Foundation Footing Blocks & Grade Beams
    const footingGeo = new THREE.BoxGeometry(2.4, 0.6, 2.4);
    const footingCoords = [
        [-6.5, -4.5], [-2.2, -4.5], [2.2, -4.5], [6.5, -4.5],
        [-6.5, 0],    [-2.2, 0],    [2.2, 0],    [6.5, 0],
        [-6.5, 4.5],  [-2.2, 4.5],  [2.2, 4.5],  [6.5, 4.5],
    ];

    footingCoords.forEach(([fx, fz]) => {
        const footing = new THREE.Mesh(footingGeo, materials.concrete);
        footing.position.set(fx, 0.3, fz);
        footing.castShadow = true;
        footing.receiveShadow = true;
        stageGroups.foundation.add(footing);
    });

    // 2. STAGE: STRUCTURAL COLUMNS & CORE
    stageGroups.columns = new THREE.Group();
    stageGroups.columns.name = 'Stage_Columns';

    // Concrete Elevator & Staircase Shear Core (Runs through all 4 levels)
    const coreGeo = new THREE.BoxGeometry(4.2, 11.5, 3.8);
    const core = new THREE.Mesh(coreGeo, materials.darkConcrete);
    core.position.set(3.5, 5.75, -1.5);
    core.castShadow = true;
    core.receiveShadow = true;
    stageGroups.columns.add(core);

    // Structural Columns
    const colHeight = 11.2;
    const colGeo = new THREE.BoxGeometry(0.55, colHeight, 0.55);

    footingCoords.forEach(([cx, cz]) => {
        if (cx === 2.2 && cz === 0) return;
        if (cx === 2.2 && cz === -4.5) return;

        const col = new THREE.Mesh(colGeo, materials.concrete);
        col.position.set(cx, colHeight / 2 + 0.6, cz);
        col.castShadow = true;
        col.receiveShadow = true;
        stageGroups.columns.add(col);

        // Steel rebar starter caps at top
        const rebarGeo = new THREE.CylinderGeometry(0.04, 0.04, 0.5, 6);
        for (let r = -0.15; r <= 0.15; r += 0.3) {
            const rebar = new THREE.Mesh(rebarGeo, materials.steel);
            rebar.position.set(cx + r, colHeight + 0.85, cz + r);
            stageGroups.columns.add(rebar);
        }
    });

    // 3. STAGE: FLOOR SLABS & CANTILEVERS
    stageGroups.slabs = new THREE.Group();
    stageGroups.slabs.name = 'Stage_Slabs';

    // Levels: Ground (0), L1 (3.4m), L2 (6.8m), L3 (10.2m)
    const slabLevels = [
        { y: 0.6, w: 16.5, d: 12.5, offsetX: 0, offsetZ: 0 },
        { y: 3.8, w: 17.2, d: 13.0, offsetX: -0.3, offsetZ: 0.2 },
        { y: 7.2, w: 16.8, d: 12.6, offsetX: 0.2, offsetZ: -0.2 },
        { y: 10.6, w: 17.5, d: 13.2, offsetX: -0.4, offsetZ: 0.1 },
    ];

    slabLevels.forEach((lvl) => {
        const slabGeo = new THREE.BoxGeometry(lvl.w, 0.45, lvl.d);
        const slab = new THREE.Mesh(slabGeo, materials.slabEdge);
        slab.position.set(lvl.offsetX, lvl.y, lvl.offsetZ);
        slab.castShadow = true;
        slab.receiveShadow = true;
        stageGroups.slabs.add(slab);

        // Perimeter edge beam accent
        const edgeBeamGeo = new THREE.BoxGeometry(lvl.w + 0.1, 0.15, lvl.d + 0.1);
        const edgeBeam = new THREE.Mesh(edgeBeamGeo, materials.steel);
        edgeBeam.position.set(lvl.offsetX, lvl.y - 0.15, lvl.offsetZ);
        stageGroups.slabs.add(edgeBeam);
    });

    // 4. STAGE: ENCLOSURE WALLS & MASONRY
    stageGroups.walls = new THREE.Group();
    stageGroups.walls.name = 'Stage_Walls';

    const wallSegments = [
        { w: 5.5, h: 2.75, d: 0.3, x: -5.0, y: 2.2, z: 6.3 },
        { w: 0.3, h: 2.75, d: 6.0, x: -8.3, y: 2.2, z: 2.5 },
        { w: 4.8, h: 2.75, d: 0.3, x: -5.5, y: 2.2, z: -6.3 },
        { w: 6.0, h: 2.95, d: 0.3, x: -4.5, y: 5.5, z: 6.4 },
        { w: 0.3, h: 2.95, d: 5.5, x: -8.5, y: 5.5, z: -1.0 },
        { w: 5.2, h: 2.95, d: 0.3, x: 0.5, y: 5.5, z: -6.4 },
        { w: 6.2, h: 2.95, d: 0.3, x: -4.8, y: 8.9, z: 6.4 },
        { w: 0.3, h: 2.95, d: 4.8, x: -8.5, y: 8.9, z: 2.0 },
    ];

    wallSegments.forEach(seg => {
        const wallGeo = new THREE.BoxGeometry(seg.w, seg.h, seg.d);
        const wall = new THREE.Mesh(wallGeo, materials.concrete);
        wall.position.set(seg.x, seg.y, seg.z);
        wall.castShadow = true;
        wall.receiveShadow = true;
        stageGroups.walls.add(wall);
    });

    // Architectural Wood Louvers on Facade
    for (let l = 0; l < 14; l++) {
        const louverGeo = new THREE.BoxGeometry(0.12, 2.7, 0.4);
        const louver = new THREE.Mesh(louverGeo, materials.woodLouver);
        louver.position.set(-1.8 + l * 0.45, 5.5, 6.45);
        louver.castShadow = true;
        stageGroups.walls.add(louver);
    }

    // 5. STAGE: CURTAIN GLAZING & WINDOWS
    stageGroups.windows = new THREE.Group();
    stageGroups.windows.name = 'Stage_Windows';

    const windowConfigs = [
        { w: 7.5, h: 2.75, d: 0.08, x: 1.5, y: 2.2, z: 6.3 },
        { w: 0.08, h: 2.75, d: 5.2, x: 8.3, y: 2.2, z: 2.8 },
        { w: 8.0, h: 2.95, d: 0.08, x: 2.2, y: 5.5, z: 6.4 },
        { w: 0.08, h: 2.95, d: 6.5, x: 8.4, y: 5.5, z: 2.0 },
        { w: 8.2, h: 2.95, d: 0.08, x: 2.0, y: 8.9, z: 6.4 },
        { w: 0.08, h: 2.95, d: 7.2, x: 8.4, y: 8.9, z: 1.5 },
    ];

    windowConfigs.forEach(wc => {
        const glassGeo = new THREE.BoxGeometry(wc.w, wc.h, wc.d);
        const glassMesh = new THREE.Mesh(glassGeo, materials.glass);
        glassMesh.position.set(wc.x, wc.y, wc.z);
        glassMesh.castShadow = false;
        glassMesh.receiveShadow = true;
        stageGroups.windows.add(glassMesh);

        const frameGeo = new THREE.BoxGeometry(wc.w + 0.05, 0.08, wc.d + 0.06);
        const topFrame = new THREE.Mesh(frameGeo, materials.steel);
        topFrame.position.set(wc.x, wc.y + wc.h / 2, wc.z);
        const botFrame = new THREE.Mesh(frameGeo, materials.steel);
        botFrame.position.set(wc.x, wc.y - wc.h / 2, wc.z);
        stageGroups.windows.add(topFrame, botFrame);
    });

    // 6. STAGE: ROOF STRUCTURE & CANOPY
    stageGroups.roof = new THREE.Group();
    stageGroups.roof.name = 'Stage_Roof';

    const roofCanopyGeo = new THREE.BoxGeometry(18.5, 0.35, 14.2);
    const roofCanopy = new THREE.Mesh(roofCanopyGeo, materials.darkConcrete);
    roofCanopy.position.set(-0.2, 12.6, 0.1);
    roofCanopy.castShadow = true;
    roofCanopy.receiveShadow = true;
    stageGroups.roof.add(roofCanopy);

    const outriggerGeo = new THREE.BoxGeometry(0.3, 0.4, 14.6);
    [-5.5, 0, 5.5].forEach(ox => {
        const outrigger = new THREE.Mesh(outriggerGeo, materials.steel);
        outrigger.position.set(ox, 12.4, 0.1);
        outrigger.castShadow = true;
        stageGroups.roof.add(outrigger);
    });

    const parapetGeo = new THREE.BoxGeometry(17.4, 0.9, 0.08);
    const parapet = new THREE.Mesh(parapetGeo, materials.glass);
    parapet.position.set(-0.4, 11.25, 6.6);
    stageGroups.roof.add(parapet);

    const mechGeo = new THREE.BoxGeometry(4.8, 1.6, 4.2);
    const mechRoom = new THREE.Mesh(mechGeo, materials.concrete);
    mechRoom.position.set(2.8, 11.6, -1.8);
    mechRoom.castShadow = true;
    stageGroups.roof.add(mechRoom);

    // 7. STAGE: FINAL ARCHITECTURAL FINISHES & SUBTLE SITE DETAILS
    stageGroups.finishes = new THREE.Group();
    stageGroups.finishes.name = 'Stage_Finishes';

    const interiorCoreGeo = new THREE.BoxGeometry(10, 2.5, 7);
    [2.2, 5.5, 8.9].forEach(iy => {
        const interior = new THREE.Mesh(interiorCoreGeo, materials.interior);
        interior.position.set(0, iy, 0);
        stageGroups.finishes.add(interior);
    });

    const stepGeo1 = new THREE.BoxGeometry(6.5, 0.25, 2.8);
    const step1 = new THREE.Mesh(stepGeo1, materials.concrete);
    step1.position.set(1.5, 0.2, 7.8);
    step1.receiveShadow = true;
    stageGroups.finishes.add(step1);

    const stepGeo2 = new THREE.BoxGeometry(5.5, 0.25, 1.8);
    const step2 = new THREE.Mesh(stepGeo2, materials.darkConcrete);
    step2.position.set(1.5, 0.4, 7.4);
    step2.receiveShadow = true;
    stageGroups.finishes.add(step2);

    const poleGeo = new THREE.CylinderGeometry(0.03, 0.03, 14, 8);
    const pole1 = new THREE.Mesh(poleGeo, materials.accentSteel);
    pole1.position.set(-9.5, 7, 7.5);
    const pole2 = new THREE.Mesh(poleGeo, materials.accentSteel);
    pole2.position.set(9.5, 7, -7.5);
    stageGroups.finishes.add(pole1, pole2);

    // Add all stages to main building group
    buildingGroup.add(
        stageGroups.foundation,
        stageGroups.columns,
        stageGroups.slabs,
        stageGroups.walls,
        stageGroups.windows,
        stageGroups.roof,
        stageGroups.finishes
    );

    // Center building slightly and tilt toward primary architectural 3/4 axonometric perspective
    buildingGroup.position.set(0, -3.5, 0);
    buildingGroup.rotation.y = -Math.PI / 6;

    scene.add(buildingGroup);
};

const setupScene = () => {
    if (!containerRef.value) return;

    const width = containerRef.value.clientWidth;
    const height = containerRef.value.clientHeight || 580;

    // 1. Scene setup
    scene = new THREE.Scene();
    scene.background = null;

    // 2. Camera Setup (Architectural Perspective Lens)
    camera = new THREE.PerspectiveCamera(38, width / height, 0.1, 100);
    camera.position.set(22, 14, 26);
    camera.lookAt(0, 2.5, 0);

    // 3. Renderer Setup
    renderer = new THREE.WebGLRenderer({
        antialias: true,
        alpha: true,
        powerPreference: 'high-performance'
    });
    renderer.setSize(width, height);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.shadowMap.enabled = true;
    renderer.shadowMap.type = THREE.PCFSoftShadowMap;
    renderer.toneMapping = THREE.ACESFilmicToneMapping;
    renderer.toneMappingExposure = 1.15;

    containerRef.value.innerHTML = '';
    containerRef.value.appendChild(renderer.domElement);

    // 4. Studio & Architectural Sun Lighting
    const sunLight = new THREE.DirectionalLight(0xfffaed, 2.2);
    sunLight.position.set(18, 32, 22);
    sunLight.castShadow = true;
    sunLight.shadow.mapSize.width = 2048;
    sunLight.shadow.mapSize.height = 2048;
    sunLight.shadow.camera.near = 5;
    sunLight.shadow.camera.far = 70;
    sunLight.shadow.camera.left = -16;
    sunLight.shadow.camera.right = 16;
    sunLight.shadow.camera.top = 16;
    sunLight.shadow.camera.bottom = -16;
    sunLight.shadow.bias = -0.0003;
    scene.add(sunLight);

    const hemiLight = new THREE.HemisphereLight(0x7ea6dc, 0x1a2130, 1.1);
    hemiLight.position.set(0, 40, 0);
    scene.add(hemiLight);

    const ambientLight = new THREE.AmbientLight(0x1e293b, 0.7);
    scene.add(ambientLight);

    const rimLight = new THREE.DirectionalLight(0x38bdf8, 0.8);
    rimLight.position.set(-20, 15, -20);
    scene.add(rimLight);

    const interiorWarm = new THREE.PointLight(0xf59e0b, 1.2, 20);
    interiorWarm.position.set(0, 3.5, 0);
    scene.add(interiorWarm);

    // 5. Ground Shadow Receiver & Architectural Site Grid
    const groundGeo = new THREE.PlaneGeometry(60, 60);
    const groundMat = new THREE.ShadowMaterial({
        opacity: 0.45,
    });
    const ground = new THREE.Mesh(groundGeo, groundMat);
    ground.rotation.x = -Math.PI / 2;
    ground.position.y = -3.7;
    ground.receiveShadow = true;
    scene.add(ground);

    const gridHelper = new THREE.GridHelper(44, 22, 0xf59e0b, 0x334155);
    gridHelper.position.y = -3.68;
    gridHelper.material.opacity = 0.22;
    gridHelper.material.transparent = true;
    scene.add(gridHelper);

    initMaterials();

    // 6. Load Model: Custom GLTF or Procedural BIM Architecture
    if (props.modelUrl) {
        loadCustomModel(props.modelUrl);
    } else {
        buildArchitecturalStructure();
        updateConstructionStage(activeStageIndex.value, true);
        isLoading.value = false;
        emit('scene-ready');
    }

    // 7. Event Listeners (360° Drag, Parallax & Scroll Integration)
    setupInteractions();
    animate();
};

const loadCustomModel = (url) => {
    isLoading.value = true;
    const loader = new GLTFLoader();

    loader.load(
        url,
        (gltf) => {
            if (buildingGroup) {
                scene.remove(buildingGroup);
            }
            customModelGroup = gltf.scene;

            const bbox = new THREE.Box3().setFromObject(customModelGroup);
            const size = bbox.getSize(new THREE.Vector3());
            const center = bbox.getCenter(new THREE.Vector3());

            const maxDim = Math.max(size.x, size.y, size.z);
            const scale = 14 / (maxDim || 1);
            customModelGroup.scale.setScalar(scale);
            customModelGroup.position.set(-center.x * scale, -center.y * scale, -center.z * scale);

            customModelGroup.traverse((child) => {
                if (child.isMesh) {
                    child.castShadow = true;
                    child.receiveShadow = true;
                    if (child.material) {
                        child.material.roughness = Math.max(0.2, child.material.roughness || 0.6);
                    }
                }
            });

            scene.add(customModelGroup);
            isLoading.value = false;
            emit('scene-ready');
        },
        undefined,
        (error) => {
            console.warn('Failed to load custom GLB model, falling back to procedural architectural building:', error);
            buildArchitecturalStructure();
            updateConstructionStage(activeStageIndex.value, true);
            isLoading.value = false;
            emit('scene-ready');
        }
    );
};

const updateConstructionStage = (stage, instant = false) => {
    if (!stageGroups.foundation) return;
    activeStageIndex.value = stage;

    const stageMap = {
        foundation: stage >= 1,
        columns: stage >= 2,
        slabs: stage >= 2,
        walls: stage >= 3,
        windows: stage >= 3,
        roof: stage >= 4,
        finishes: stage >= 4
    };

    Object.keys(stageGroups).forEach((key) => {
        const group = stageGroups[key];
        if (!group) return;

        const isVisibleTarget = stageMap[key];

        if (instant) {
            group.visible = isVisibleTarget;
            group.scale.set(1, isVisibleTarget ? 1 : 0.001, 1);
            group.position.y = isVisibleTarget ? 0 : -0.5;
        } else {
            if (isVisibleTarget) {
                group.visible = true;
            }
        }
    });

    emit('stage-change', stage);
};

const setupInteractions = () => {
    const el = containerRef.value;
    if (!el) return;

    // Mouse Down / Drag Start
    const handlePointerDown = (e) => {
        isDragging = true;
        isUserDragging.value = true;
        previousPointerPos = {
            x: e.clientX || (e.touches && e.touches[0].clientX) || 0,
            y: e.clientY || (e.touches && e.touches[0].clientY) || 0
        };
    };

    // Mouse / Touch Move
    const handlePointerMove = (e) => {
        const clientX = e.clientX || (e.touches && e.touches[0].clientX) || 0;
        const clientY = e.clientY || (e.touches && e.touches[0].clientY) || 0;

        if (isDragging) {
            const deltaX = clientX - previousPointerPos.x;
            const deltaY = clientY - previousPointerPos.y;

            // 360° Horizontal Rotation & Controlled Vertical Tilt
            targetUserRotationY += deltaX * 0.008;
            targetUserRotationX = Math.max(-0.5, Math.min(0.6, targetUserRotationX + deltaY * 0.006));

            previousPointerPos = { x: clientX, y: clientY };
        } else {
            // Subtle hover parallax when not actively dragging
            const rect = el.getBoundingClientRect();
            const x = ((clientX - rect.left) / rect.width) * 2 - 1;
            const y = -(((clientY - rect.top) / rect.height) * 2 - 1);

            mouse.targetX = Math.max(-1, Math.min(1, x)) * 0.25;
            mouse.targetY = Math.max(-1, Math.min(1, y)) * 0.20;
        }
    };

    // Mouse Up / Drag End
    const handlePointerUp = () => {
        isDragging = false;
        isUserDragging.value = false;
    };

    el.addEventListener('mousedown', handlePointerDown);
    window.addEventListener('mousemove', handlePointerMove, { passive: true });
    window.addEventListener('mouseup', handlePointerUp);

    el.addEventListener('touchstart', handlePointerDown, { passive: true });
    window.addEventListener('touchmove', handlePointerMove, { passive: true });
    window.addEventListener('touchend', handlePointerUp);

    // Continuous Scroll-based Position & Perspective
    const handleScroll = () => {
        if (!containerRef.value) return;
        const rect = containerRef.value.getBoundingClientRect();
        const windowHeight = window.innerHeight;
        const midPoint = rect.top + rect.height / 2;
        const normalized = (midPoint - windowHeight / 2) / windowHeight;
        scrollFactor = Math.max(-1, Math.min(1, normalized)) * 2.5;

        // Page scroll progress strictly drives rotation
        const scrollMax = document.documentElement.scrollHeight - windowHeight;
        if (scrollMax > 0) {
            const progress = Math.min(1, Math.max(0, window.scrollY / scrollMax));
            targetScrollDrivenRotation = progress * Math.PI * 1.4;
        }
    };
    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll();

    // Visibility Observer to pause rendering when offscreen
    intersectionObserver = new IntersectionObserver(([entry]) => {
        isVisible = entry.isIntersecting;
    }, { threshold: 0.02 });

    intersectionObserver.observe(containerRef.value);

    // Resize Observer
    resizeObserver = new ResizeObserver(() => {
        handleResize();
    });
    resizeObserver.observe(containerRef.value);
};

const handleResize = () => {
    if (!containerRef.value || !renderer || !camera) return;
    const width = containerRef.value.clientWidth;
    const height = containerRef.value.clientHeight || 580;

    camera.aspect = width / height;
    camera.updateProjectionMatrix();
    renderer.setSize(width, height);
};

const animate = () => {
    animationFrameId = requestAnimationFrame(animate);

    if (!isVisible || !renderer || !scene || !camera) return;

    // Smooth Lerping for 360° User Drag Rotation & Damping
    userRotationY += (targetUserRotationY - userRotationY) * 0.08;
    userRotationX += (targetUserRotationX - userRotationX) * 0.08;

    // Smooth Lerping for scroll-driven rotation (Scroll DOWN -> rotates forward, Scroll UP -> reverses)
    scrollDrivenRotation += (targetScrollDrivenRotation - scrollDrivenRotation) * 0.07;

    // Smooth Lerping for subtle parallax
    mouse.x += (mouse.targetX - mouse.x) * 0.04;
    mouse.y += (mouse.targetY - mouse.y) * 0.04;

    const activeGroup = customModelGroup || buildingGroup;

    if (activeGroup) {
        // Base -30 deg + user drag + smooth scroll-linked rotation
        activeGroup.rotation.y = -Math.PI / 6 + userRotationY + scrollDrivenRotation;
        activeGroup.rotation.x = userRotationX;
    }

    // Camera perspective interpolation
    const baseCamX = 22;
    const baseCamY = 14;
    const baseCamZ = 26;

    camera.position.x = baseCamX + mouse.x * 3.5 - Math.sin(scrollDrivenRotation * 0.5) * 3;
    camera.position.y = baseCamY + mouse.y * 2.5 + scrollFactor * 0.8;
    camera.position.z = baseCamZ - mouse.x * 2.0;

    camera.lookAt(0, 2.2 + scrollFactor * 0.3, 0);

    // Smooth transition of construction stage groups
    if (stageGroups.foundation) {
        const stageMap = {
            foundation: activeStageIndex.value >= 1,
            columns: activeStageIndex.value >= 2,
            slabs: activeStageIndex.value >= 2,
            walls: activeStageIndex.value >= 3,
            windows: activeStageIndex.value >= 3,
            roof: activeStageIndex.value >= 4,
            finishes: activeStageIndex.value >= 4
        };

        Object.keys(stageGroups).forEach((key) => {
            const group = stageGroups[key];
            if (!group) return;
            const targetVisible = stageMap[key];

            if (targetVisible) {
                group.visible = true;
                group.scale.y += (1 - group.scale.y) * 0.08;
                group.position.y += (0 - group.position.y) * 0.08;
            } else {
                group.scale.y += (0.001 - group.scale.y) * 0.12;
                group.position.y += (-0.4 - group.position.y) * 0.12;
                if (group.scale.y < 0.02) {
                    group.visible = false;
                }
            }
        });
    }

    renderer.render(scene, camera);
};

watch(() => props.currentStage, (newStage) => {
    updateConstructionStage(newStage);
});

watch(() => props.modelUrl, (newUrl) => {
    if (newUrl && scene) {
        loadCustomModel(newUrl);
    }
});

onMounted(() => {
    if (checkWebGL()) {
        setupScene();
    } else {
        webGlSupported.value = false;
        isLoading.value = false;
    }
});

onBeforeUnmount(() => {
    if (animationFrameId) {
        cancelAnimationFrame(animationFrameId);
    }
    if (intersectionObserver) {
        intersectionObserver.disconnect();
    }
    if (resizeObserver) {
        resizeObserver.disconnect();
    }

    // Dispose Materials and Geometries
    if (scene) {
        scene.traverse((obj) => {
            if (obj.geometry) obj.geometry.dispose();
            if (obj.material) {
                if (Array.isArray(obj.material)) {
                    obj.material.forEach((mat) => mat.dispose());
                } else {
                    obj.material.dispose();
                }
            }
        });
    }

    if (renderer) {
        renderer.dispose();
        if (renderer.domElement && renderer.domElement.parentNode) {
            renderer.domElement.parentNode.removeChild(renderer.domElement);
        }
    }
});

defineExpose({
    setStage: (stage) => updateConstructionStage(stage),
    getStage: () => activeStageIndex.value
});
</script>

<template>
    <div 
        class="relative w-full h-[480px] sm:h-[540px] lg:h-[620px] rounded-3xl overflow-hidden bg-gradient-to-b from-[#0e1626] via-[#0b1120] to-[#080d18] border border-slate-800/80 shadow-2xl group select-none"
        :class="isUserDragging ? 'cursor-grabbing' : 'cursor-grab'"
    >
        <!-- Blueprint Technical Grid Underlay -->
        <div class="absolute inset-0 bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:24px_24px] opacity-[0.07] pointer-events-none"></div>

        <!-- 3D Three.js Container with 360° Drag Support -->
        <div v-show="webGlSupported" ref="containerRef" class="w-full h-full"></div>

        <!-- Architectural HUD Coordinates & Elevation Markers -->
        <div class="absolute top-6 left-6 pointer-events-none flex flex-col gap-1 z-10">
            <div class="flex items-center gap-2">
                <span class="inline-block w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                <span class="text-[10px] font-mono font-bold tracking-widest text-slate-300 uppercase">360° INTERACTIVE BIM MODEL</span>
            </div>
            <span class="text-[9px] font-mono text-slate-500 tracking-wider">CLICK & DRAG TO ROTATE / SCROLL TO EXPLORE</span>
        </div>

        <div class="absolute top-6 right-6 pointer-events-none z-10 hidden sm:flex items-center gap-4">
            <div class="px-3 py-1 bg-slate-900/80 backdrop-blur border border-slate-700/60 rounded-lg text-right">
                <span class="text-[8px] font-mono uppercase text-slate-400 block tracking-widest">360° AXONOMETRIC</span>
                <span class="text-[10px] font-mono font-bold text-amber-400">SMOOTH INERTIA</span>
            </div>
        </div>

        <!-- Architectural Level Elevation Ticks (Right Side) -->
        <div class="absolute right-6 top-1/2 -translate-y-1/2 hidden md:flex flex-col gap-6 pointer-events-none z-10">
            <div class="flex items-center gap-3 justify-end group/lvl">
                <span class="text-[9px] font-mono text-slate-400 transition-colors">LVL +12.60 ROOF & CANOPY</span>
                <div class="w-4 h-[1px] bg-slate-600"></div>
            </div>
            <div class="flex items-center gap-3 justify-end group/lvl">
                <span class="text-[9px] font-mono text-slate-400 transition-colors">LVL +08.90 TOWER GLAZING</span>
                <div class="w-4 h-[1px] bg-slate-600"></div>
            </div>
            <div class="flex items-center gap-3 justify-end group/lvl">
                <span class="text-[9px] font-mono text-slate-400 transition-colors">LVL +05.50 CANTILEVER SLAB</span>
                <div class="w-4 h-[1px] bg-slate-600"></div>
            </div>
            <div class="flex items-center gap-3 justify-end group/lvl">
                <span class="text-[9px] font-mono text-slate-400 transition-colors">LVL +02.20 PODIUM ENTRY</span>
                <div class="w-4 h-[1px] bg-slate-600"></div>
            </div>
            <div class="flex items-center gap-3 justify-end group/lvl">
                <span class="text-[9px] font-mono text-amber-400 font-bold">LVL ±0.00 FOUNDATION GRADE</span>
                <div class="w-6 h-[1.5px] bg-amber-400"></div>
            </div>
        </div>

        <!-- Interactive Drag Hint Badge (Bottom Right) -->
        <div class="absolute bottom-6 right-6 pointer-events-none z-10 hidden sm:flex items-center gap-2 px-3 py-1.5 bg-slate-900/90 border border-slate-700/80 rounded-full">
            <svg class="w-3.5 h-3.5 text-amber-400 animate-spin" style="animation-duration: 6s;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            <span class="text-[9px] font-mono uppercase text-slate-300 tracking-wider">360° Drag Inspection</span>
        </div>

        <!-- Loading Overlay -->
        <div v-if="isLoading" class="absolute inset-0 bg-[#0b1120]/90 backdrop-blur-sm flex flex-col items-center justify-center gap-4 z-20">
            <div class="w-10 h-10 border-2 border-amber-400/20 border-t-amber-400 rounded-full animate-spin"></div>
            <p class="text-[10px] font-mono font-bold uppercase tracking-[0.3em] text-slate-400">Generating Architectural BIM Geometry...</p>
        </div>

        <!-- Fallback for Non-WebGL Devices -->
        <div v-if="!webGlSupported" class="w-full h-full flex flex-col items-center justify-center p-8 text-center bg-[#0e1626]">
            <div class="w-16 h-16 rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <h4 class="text-base font-bold text-white uppercase tracking-tight mb-2">Architectural Visualization</h4>
            <p class="text-xs text-slate-400 max-w-sm font-medium">Real-time architectural model rendering requires WebGL. Viewing 2D structural diagram.</p>
        </div>
    </div>
</template>

<style scoped>
/* High performance canvas rendering */
canvas {
    outline: none;
    display: block;
}
</style>

import { Suspense, useMemo, useRef } from 'react'
import { Canvas, useFrame } from '@react-three/fiber'
import { Float, ContactShadows, useGLTF } from '@react-three/drei'
import { useScroll, useTransform, useMotionValueEvent } from 'framer-motion'
import { Box3, Vector3 } from 'three'

const MODEL_URL = '/models/salmon-nigiri/scene.gltf'
const TARGET_SIZE = 2.6 // world units across the model's longest side

function SushiModel({ scrollYProgress }) {
  const group = useRef()
  const { scene } = useGLTF(MODEL_URL)

  // Sketchfab exports come in arbitrary units/pivots — normalize scale
  // and re-center on load instead of hand-tuning per-model numbers.
  const normalized = useMemo(() => {
    const clone = scene.clone(true)
    clone.traverse((obj) => {
      if (obj.isMesh) {
        obj.castShadow = true
        obj.receiveShadow = true
      }
    })

    const box = new Box3().setFromObject(clone)
    const size = new Vector3()
    box.getSize(size)
    const center = new Vector3()
    box.getCenter(center)
    const scale = TARGET_SIZE / Math.max(size.x, size.y, size.z)

    clone.scale.setScalar(scale)
    clone.position.set(-center.x * scale, -box.min.y * scale, -center.z * scale)
    return clone
  }, [scene])

  useFrame((state, delta) => {
    if (!group.current) return
    group.current.rotation.y += delta * 0.25
  })

  useMotionValueEvent(scrollYProgress, 'change', (v) => {
    if (!group.current) return
    group.current.position.y = -1.7 - v * 2.2
    group.current.rotation.x = v * 0.9
    group.current.rotation.z = v * 0.25
    const s = 1 - v * 0.35
    group.current.scale.set(s, s, s)
  })

  return (
    <group ref={group} position={[0, -1.7, 0]}>
      <Float speed={1.4} rotationIntensity={0.2} floatIntensity={0.4}>
        <primitive object={normalized} />
      </Float>
    </group>
  )
}

useGLTF.preload(MODEL_URL)

export default function HeroScene({ scrollTarget }) {
  const { scrollYProgress } = useScroll({
    target: scrollTarget,
    offset: ['start start', 'end start'],
  })
  const cameraZ = useTransform(scrollYProgress, [0, 1], [7, 9.5])

  return (
    <Canvas
      shadows
      dpr={[1, 1.75]}
      camera={{ position: [0, 0.9, 7.5], fov: 38 }}
      gl={{ alpha: true, antialias: true }}
      className="!absolute inset-0"
    >
      <Suspense fallback={null}>
        <ambientLight intensity={0.7} />
        <directionalLight position={[4, 6, 4]} intensity={1.8} castShadow shadow-mapSize={[1024, 1024]} />
        <directionalLight position={[-3, 2, -4]} intensity={0.5} color="#c6a15b" />
        <pointLight position={[-4, 2, -3]} intensity={0.4} color="#c6a15b" />
        <SushiModel scrollYProgress={scrollYProgress} />
        <ContactShadows position={[0, -2.2, 0]} opacity={0.5} scale={4.5} blur={2.4} far={2} />
        <CameraRig cameraZ={cameraZ} />
      </Suspense>
    </Canvas>
  )
}

function CameraRig({ cameraZ }) {
  useFrame((state) => {
    state.camera.position.z = cameraZ.get()
    state.camera.lookAt(0, -1.3, 0)
  })
  return null
}

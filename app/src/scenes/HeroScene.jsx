import { Suspense, useMemo, useRef } from 'react'
import { Canvas, useFrame } from '@react-three/fiber'
import { Environment, Float, ContactShadows } from '@react-three/drei'
import { useScroll, useTransform, useMotionValueEvent } from 'framer-motion'

function Chopstick({ position, rotation }) {
  return (
    <mesh position={position} rotation={rotation} castShadow>
      <cylinderGeometry args={[0.025, 0.015, 2.2, 12]} />
      <meshStandardMaterial color="#3b2a1a" roughness={0.4} metalness={0.1} />
    </mesh>
  )
}

function Topping({ angle, radius, color, y = 0.62 }) {
  const x = Math.cos(angle) * radius
  const z = Math.sin(angle) * radius
  return (
    <mesh position={[x, y, z]} castShadow>
      <sphereGeometry args={[0.16, 16, 16]} />
      <meshStandardMaterial color={color} roughness={0.35} metalness={0.05} />
    </mesh>
  )
}

function SushiRoll({ scrollYProgress }) {
  const group = useRef()
  const toppingColors = useMemo(() => ['#e2725b', '#f2c14e', '#7a9e5f', '#e2725b', '#f2c14e', '#7a9e5f'], [])

  useFrame((state, delta) => {
    if (!group.current) return
    group.current.rotation.y += delta * 0.25
  })

  useMotionValueEvent(scrollYProgress, 'change', (v) => {
    if (!group.current) return
    group.current.position.y = -2 - v * 2.2
    group.current.rotation.x = v * 0.9
    group.current.rotation.z = v * 0.25
    const s = 1 - v * 0.35
    group.current.scale.set(s, s, s)
  })

  return (
    <group ref={group} position={[0, -2, 0]}>
      <Float speed={1.4} rotationIntensity={0.25} floatIntensity={0.5}>
        {/* nori-wrapped rice cylinder */}
        <mesh castShadow receiveShadow>
          <cylinderGeometry args={[0.62, 0.62, 0.8, 48]} />
          <meshStandardMaterial color="#1a1a1a" roughness={0.55} metalness={0.05} />
        </mesh>
        <mesh position={[0, 0.001, 0]}>
          <cylinderGeometry args={[0.5, 0.5, 0.82, 48]} />
          <meshStandardMaterial color="#f4ead1" roughness={0.9} />
        </mesh>
        {[...Array(6)].map((_, i) => (
          <Topping key={i} angle={(i / 6) * Math.PI * 2} radius={0.36} y={0.44} color={toppingColors[i]} />
        ))}
        {/* plate */}
        <mesh position={[0, -0.49, 0]} receiveShadow>
          <cylinderGeometry args={[1.35, 1.5, 0.1, 64]} />
          <meshStandardMaterial color="#efe9e3" roughness={0.3} metalness={0.1} />
        </mesh>
      </Float>
      <Chopstick position={[1.15, -0.38, 0.55]} rotation={[0, 0.55, Math.PI / 2.1]} />
      <Chopstick position={[1.32, -0.38, 0.28]} rotation={[0, 0.55, Math.PI / 2.1]} />
    </group>
  )
}

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
        <ambientLight intensity={0.5} />
        <directionalLight position={[4, 6, 4]} intensity={1.4} castShadow shadow-mapSize={[1024, 1024]} />
        <pointLight position={[-4, 2, -3]} intensity={0.6} color="#c6a15b" />
        <SushiRoll scrollYProgress={scrollYProgress} />
        <ContactShadows position={[0, -2.5, 0]} opacity={0.5} scale={4.5} blur={2.4} far={2} />
        <Environment preset="city" />
        <CameraRig cameraZ={cameraZ} />
      </Suspense>
    </Canvas>
  )
}

function CameraRig({ cameraZ }) {
  useFrame((state) => {
    state.camera.position.z = cameraZ.get()
    state.camera.lookAt(0, -1.6, 0)
  })
  return null
}

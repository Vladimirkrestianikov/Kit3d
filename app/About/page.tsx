// app/about/page.tsx
'use client'

import { useState } from 'react'

export default function About() {
  const [hoveredCard, setHoveredCard] = useState<number | null>(null)

  const stats = [
    { number: "5+", label: "Лет опыта" },
    { number: "2000+", label: "Проектов" },
    { number: "25+", label: "Категорий" },
    { number: "98%", label: "Успешный продаж" }
  ]

  const advantages = [
    "Бесплатные и платные 3д модели",
    "Быстрая Оплата",
    "Партнерства с ведущими предприятиями",
    "Круглосуточная поддержка",
    "Размещение собственных моделей для своих нужд"
  ]

  const directions = [
    {
      title: "Специализированные модели под заказ",
      description: "Заказ модели любой сложности под ваши нужды"
    },
    {
      title: "Персонажи и интерестные фигурки",
      description: "Персонажи из разных игр и фильмов"
    },
    {
      title: "Промышленные детали ",
      description: "Детали созданные для работы или декора"
    }
  ]

 const values = [
    { icon: "🎯", text: "Качество и детализация" },
    { icon: "🤝", text: "Сообщество и сотрудничество" },
    { icon: "🔓", text: "Доступность и открытость" },
    { icon: "🌱", text: "Постоянное развитие" },
    { icon: "🌍", text: "Разнообразие и универсальность" }
]
  return (
    <div style={{
      minHeight: '100vh',
      backgroundColor: 'white',
      fontFamily: 'Arial, sans-serif'
    }}>
      <style jsx>{`
        .container {
          max-width: 1200px;
          margin: 0 auto;
          padding: 0 20px;
        }
        
        .hero-section {
          background: linear-gradient(135deg, #ff6b35, #4caf50);
          color: white;
          padding: 80px 20px;
          text-align: center;
        }
        
        .hero-title {
          font-size: 3rem;
          font-weight: bold;
          margin-bottom: 24px;
        }
        
        .hero-subtitle {
          font-size: 1.25rem;
          max-width: 800px;
          margin: 0 auto;
          line-height: 1.6;
        }
        
        .content-section {
          padding: 80px 0;
        }
        
        .grid-2 {
          display: grid;
          grid-template-columns: 1fr;
          gap: 48px;
        }
        
        @media (min-width: 768px) {
          .grid-2 {
            grid-template-columns: 1fr 1fr;
          }
        }
        
        .grid-3 {
          display: grid;
          grid-template-columns: 1fr;
          gap: 24px;
        }
        
        @media (min-width: 768px) {
          .grid-3 {
            grid-template-columns: repeat(3, 1fr);
          }
        }
        
        .grid-4 {
          display: grid;
          grid-template-columns: repeat(2, 1fr);
          gap: 32px;
        }
        
        @media (min-width: 768px) {
          .grid-4 {
            grid-template-columns: repeat(4, 1fr);
          }
        }
        
        .section-title {
          font-size: 2.5rem;
          font-weight: bold;
          color: #1f2937;
          margin-bottom: 24px;
        }
        
        .section-subtitle {
          font-size: 2rem;
          font-weight: bold;
          color: #1f2937;
          margin-bottom: 48px;
          text-align: center;
        }
        
        .text-lg {
          font-size: 1.125rem;
          line-height: 1.7;
          color: #6b7280;
        }
        
        .advantage-box {
          background-color: #f0fdf4;
          border-radius: 16px;
          padding: 32px;
          border-left: 4px solid #ff6b35;
        }
        
        .advantage-list {
          list-style: none;
          padding: 0;
        }
        
        .advantage-item {
          display: flex;
          align-items: center;
          margin-bottom: 12px;
        }
        
        .advantage-dot {
          width: 8px;
          height: 8px;
          background-color: #ff6b35;
          border-radius: 50%;
          margin-right: 12px;
        }
        
        .stats-section {
          background-color: #fff7ed;
          border-radius: 16px;
          padding: 48px;
          margin-bottom: 64px;
        }
        
        .stat-card {
          background-color: white;
          border-radius: 12px;
          padding: 24px;
          text-align: center;
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .stat-number {
          font-size: 2rem;
          font-weight: bold;
          color: #16a34a;
          margin-bottom: 8px;
        }
        
        .direction-card {
          background: linear-gradient(135deg, #fb923c, #dc2626);
          color: white;
          border-radius: 16px;
          padding: 32px;
          box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
          transition: transform 0.3s ease;
          cursor: pointer;
        }
        
        .direction-card:hover {
          transform: scale(1.05);
        }
        
        .direction-card:nth-child(2) {
          background: linear-gradient(135deg, #4ade80, #16a34a);
        }
        
        .direction-card:nth-child(3) {
          background: linear-gradient(135deg, #ff6b35, #4caf50);
        }
        
        .mission-section {
          background: linear-gradient(90deg, white, #f0fdf4);
          border-radius: 16px;
          padding: 48px;
          border: 1px solid #fed7aa;
        }
        
        .value-item {
          display: flex;
          align-items: center;
          margin-bottom: 16px;
        }
        
        .value-icon {
          font-size: 1.5rem;
          margin-right: 16px;
        }
        
        .cta-section {
          background: linear-gradient(135deg, #ff6b35, #4caf50);
          padding: 64px 20px;
          text-align: center;
          color: white;
        }
        
        .cta-title {
          font-size: 2.25rem;
          font-weight: bold;
          margin-bottom: 16px;
        }
        
        .cta-subtitle {
          font-size: 1.25rem;
          max-width: 600px;
          margin: 0 auto 32px;
          line-height: 1.6;
        }
        
        .button {
          padding: 12px 32px;
          border-radius: 25px;
          font-weight: bold;
          font-size: 1rem;
          cursor: pointer;
          transition: all 0.3s ease;
          border: none;
          margin: 0 8px;
        }
        
        .button-primary {
          background-color: white;
          color: #ff6b35;
        }
        
        .button-primary:hover {
          background-color: #f8fafc;
        }
        
        .button-secondary {
          background-color: transparent;
          color: white;
          border: 2px solid white;
        }
        
        .button-secondary:hover {
          background-color: white;
          color: #ff6b35;
        }
      `}</style>

      {/* Hero Section */}
      <section className="hero-section">
        <div className="container">
          <h1 className="hero-title">Kit3d</h1>
          <p className="hero-subtitle">
            Платформа разработанная студентами образовательногго учреждение
            ATC_Pavlodar
          </p>
        </div>
      </section>

      {/* Основной контент */}
      <div className="container">
        <section className="content-section">
          {/* О колледже */}
          <div className="grid-2">
            <div>
              <h2 className="section-title">О нашем колледже</h2>
              <div style={{ lineHeight: '1.7' }}>
                <p className="text-lg">
                  <span style={{ fontWeight: 'bold', color: '#ff6b35' }}>Колледж ATC-Pavlodar</span> — 
                  современное образовательное учреждение, которое с 2010 года готовит 
                  высококвалифицированных специалистов для различных отраслей экономики.
                </p>
                <p className="text-lg">
                  Мы сочетаем в себе богатые образовательные традиции и передовые 
                  технологии обучения, создавая идеальную среду для профессионального 
                  роста и развития.
                </p>
                <p className="text-lg" style={{ fontWeight: 'bold', color: '#16a34a' }}>
                  Наш девиз: «Образование, которое открывает возможности!»
                </p>
              </div>
            </div>
            <div className="advantage-box">
              <h3 style={{ fontSize: '1.5rem', fontWeight: 'bold', color: '#1f2937', marginBottom: '24px' }}>
                Наши преимущества
              </h3>
              <ul className="advantage-list">
                {advantages.map((item, index) => (
                  <li key={index} className="advantage-item">
                    <div className="advantage-dot"></div>
                    <span style={{ color: '#374151' }}>{item}</span>
                  </li>
                ))}
              </ul>
            </div>
          </div>
        </section>

        {/* Статистика */}
        <section className="stats-section">
          <h2 className="section-subtitle">Нынещние результаты  Kit3d</h2>
          <div className="grid-4">
            {stats.map((stat, index) => (
              <div key={index} className="stat-card">
                <div className="stat-number">{stat.number}</div>
                <div style={{ color: '#6b7280', fontWeight: '500' }}>{stat.label}</div>
              </div>
            ))}
          </div>
        </section>

        {/* Направления подготовки */}
        <section className="content-section">
          <h2 className="section-subtitle">Основные направления</h2>
          <div className="grid-3">
            {directions.map((direction, index) => (
              <div 
                key={index}
                className="direction-card"
                onMouseEnter={() => setHoveredCard(index)}
                onMouseLeave={() => setHoveredCard(null)}
                style={{
                  transform: hoveredCard === index ? 'scale(1.05)' : 'scale(1)'
                }}
              >
                <h3 style={{ fontSize: '1.25rem', fontWeight: 'bold', marginBottom: '16px' }}>
                  {direction.title}
                </h3>
                <p style={{ opacity: 0.9 }}>{direction.description}</p>
              </div>
            ))}
          </div>
        </section>

        {/* Миссия и ценности */}
        <section className="mission-section">
          <div className="grid-2">
            <div>
              <h2 className="section-title">Наша миссия</h2>
              <p className="text-lg">
               Сделать 3D моделирование доступным для каждого. Мы создаем платформу, где дизайнеры, разработчики и энтузиасты могут находить, создавать и обмениваться высококачественными 3D моделями.
              </p>
            </div>
            <div>
              <h2 className="section-title">Наши ценности</h2>
              <div>
                {values.map((value, index) => (
                  <div key={index} className="value-item">
                    <span className="value-icon">{value.icon}</span>
                    <span style={{ color: '#374151', fontWeight: '500' }}>{value.text}</span>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </section>
      </div>

      {/* CTA Section */}
      <section className="cta-section">
        <div className="container">
          <h2 className="cta-title">Готовы стать частью нашей семьи?</h2>
          <p className="cta-subtitle">
            Присоединяйтесь к тысячам пользователей, которые уже выбрали Kit3d для своего профессионального пути
          </p>
          <div>
            <a href="/Ab"></a>
            <button className="button button-primary">перейти к 3d Моделям</button>
            
          </div>
        </div>
      </section>
    </div>
  )
}
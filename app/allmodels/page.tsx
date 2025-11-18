// app/allmodels/page.tsx
'use client'

import { useState } from 'react'

const demoModels = [
  {
    id: 1,
    title: "FREE 1975 Porsche 911",
    description: "Classic sports car with detailed interior and exterior",
    category: "Cars & Vehicles",
    price: 0,
    rating: 4.9,
    downloads: 738700,
    likes: 255,
    author: "VintageCars3D",
    tags: ["car", "vehicle", "sports", "classic"],
    polygonCount: "850K",
    fileFormat: "GLTF",
    isFree: true,
    isStaffPick: true,
    license: "CC BY"
  },
  {
    id: 2,
    title: "FREE 1972 Datsun 240K",
    description: "Vintage Japanese classic car with realistic materials",
    category: "Cars & Vehicles",
    price: 0,
    rating: 4.8,
    downloads: 506000,
    likes: 232,
    author: "RetroRides",
    tags: ["jdm", "vintage", "car", "classic"],
    polygonCount: "720K",
    fileFormat: "GLTF",
    isFree: true,
    license: "CC BY"
  },
  {
    id: 3,
    title: "FREE Cyberpunk Motorcycle",
    description: "Futuristic bike with neon lights and detailed mechanics",
    category: "Cars & Vehicles",
    price: 0,
    rating: 4.7,
    downloads: 214100,
    likes: 78,
    author: "CyberDesign",
    tags: ["cyberpunk", "motorcycle", "futuristic"],
    polygonCount: "450K",
    fileFormat: "FBX",
    isFree: true,
    isStaffPick: true,
    license: "CC BY"
  },
  {
    id: 4,
    title: "FREE Porsche 911 GT3",
    description: "Modern sports car with racing livery",
    category: "Cars & Vehicles",
    price: 0,
    rating: 4.8,
    downloads: 569200,
    likes: 101,
    author: "SupercarStudio",
    tags: ["porsche", "sports", "racing"],
    polygonCount: "920K",
    fileFormat: "GLTF",
    isFree: true,
    license: "CC BY"
  },
  {
    id: 5,
    title: "Old Rusty Car",
    description: "Abandoned vehicle with realistic rust and decay",
    category: "Cars & Vehicles",
    price: 12.99,
    rating: 4.6,
    downloads: 302400,
    likes: 80,
    author: "AbandonedArts",
    tags: ["rusty", "abandoned", "post-apocalyptic"],
    polygonCount: "380K",
    fileFormat: "OBJ",
    isFree: false,
    license: "Standard"
  },
  {
    id: 6,
    title: "Pony Cartoon Character",
    description: "Stylized cartoon character with friendly design",
    category: "Characters",
    price: 8.99,
    rating: 4.7,
    downloads: 727800,
    likes: 150,
    author: "CartoonWorks",
    tags: ["cartoon", "character", "stylized"],
    polygonCount: "25K",
    fileFormat: "BLEND",
    isFree: false,
    license: "Standard"
  },
  {
    id: 7,
    title: "Ship in a Bottle",
    description: "Detailed miniature ship inside glass bottle",
    category: "Props",
    price: 0,
    rating: 4.5,
    downloads: 133600,
    likes: 80,
    author: "MiniatureMagic",
    tags: ["ship", "bottle", "miniature"],
    polygonCount: "85K",
    fileFormat: "GLTF",
    isFree: true,
    license: "CC BY"
  }
]

export default function AllModelsPage() {
  const [selectedCategory, setSelectedCategory] = useState('all')
  const [selectedLicense, setSelectedLicense] = useState('any')
  const [selectedDate, setSelectedDate] = useState('all-time')
  const [showDownloadable, setShowDownloadable] = useState(true)
  const [showAnimated, setShowAnimated] = useState(false)
  const [showStaffPicks, setShowStaffPicks] = useState(false)

  const categories = [
    { value: 'all', label: 'All Categories' },
    { value: 'Cars & Vehicles', label: 'Cars & Vehicles' },
    { value: 'Characters', label: 'Characters' },
    { value: 'Architecture', label: 'Architecture' },
    { value: 'Props', label: 'Props' },
    { value: 'Environments', label: 'Environments' }
  ]

  const licenses = [
    { value: 'any', label: 'Any' },
    { value: 'free', label: 'FREE' },
    { value: 'premium', label: 'Premium' },
    { value: 'CC BY', label: 'CC BY' }
  ]

  const dates = [
    { value: 'all-time', label: 'All time' },
    { value: 'this-week', label: 'This week' },
    { value: 'this-month', label: 'This month' },
    { value: 'this-year', label: 'This year' }
  ]

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <div className="bg-white border-b border-gray-200">
        <div className="container mx-auto px-4 py-6">
          <div className="flex items-center justify-between mb-6">
            <h1 className="text-2xl font-bold text-gray-900">3D Gallery</h1>
            <div className="relative w-96">
              <input
                type="text"
                placeholder="Search 3D models..."
                className="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              />
              <div className="absolute left-3 top-2.5 text-gray-400">
                🔍
              </div>
            </div>
          </div>

          <div className="flex gap-6">
            {/* Left Sidebar */}
            <div className="w-64 space-y-6">
              {/* Category Section */}
              <div>
                <h3 className="font-semibold text-gray-900 mb-3">Category</h3>
                <div className="space-y-2">
                  {categories.map(category => (
                    <label key={category.value} className="flex items-center space-x-2 cursor-pointer">
                      <input
                        type="radio"
                        name="category"
                        value={category.value}
                        checked={selectedCategory === category.value}
                        onChange={(e) => setSelectedCategory(e.target.value)}
                        className="text-blue-600 focus:ring-blue-500"
                      />
                      <span className="text-gray-700">{category.label}</span>
                    </label>
                  ))}
                </div>
              </div>

              <div className="border-t border-gray-200 pt-4">
                <h3 className="font-semibold text-gray-900 mb-3">DATE</h3>
                <div className="space-y-2">
                  {dates.map(date => (
                    <label key={date.value} className="flex items-center space-x-2 cursor-pointer">
                      <input
                        type="radio"
                        name="date"
                        value={date.value}
                        checked={selectedDate === date.value}
                        onChange={(e) => setSelectedDate(e.target.value)}
                        className="text-blue-600 focus:ring-blue-500"
                      />
                      <span className="text-gray-700">{date.label}</span>
                    </label>
                  ))}
                </div>
              </div>

              <div className="border-t border-gray-200 pt-4">
                <h3 className="font-semibold text-gray-900 mb-3">LICENSES</h3>
                <div className="space-y-2">
                  {licenses.map(license => (
                    <label key={license.value} className="flex items-center space-x-2 cursor-pointer">
                      <input
                        type="radio"
                        name="license"
                        value={license.value}
                        checked={selectedLicense === license.value}
                        onChange={(e) => setSelectedLicense(e.target.value)}
                        className="text-blue-600 focus:ring-blue-500"
                      />
                      <span className="text-gray-700">{license.label}</span>
                    </label>
                  ))}
                </div>
              </div>

              <div className="border-t border-gray-200 pt-4">
                <h3 className="font-semibold text-gray-900 mb-3">OTHERS</h3>
                <div className="space-y-3">
                  <label className="flex items-center space-x-2 cursor-pointer">
                    <input
                      type="checkbox"
                      checked={showDownloadable}
                      onChange={(e) => setShowDownloadable(e.target.checked)}
                      className="text-blue-600 focus:ring-blue-500"
                    />
                    <span className="text-gray-700">Downloadable</span>
                  </label>
                  <label className="flex items-center space-x-2 cursor-pointer">
                    <input
                      type="checkbox"
                      checked={showAnimated}
                      onChange={(e) => setShowAnimated(e.target.checked)}
                      className="text-blue-600 focus:ring-blue-500"
                    />
                    <span className="text-gray-700">Animated</span>
                  </label>
                  <label className="flex items-center space-x-2 cursor-pointer">
                    <input
                      type="checkbox"
                      checked={showStaffPicks}
                      onChange={(e) => setShowStaffPicks(e.target.checked)}
                      className="text-blue-600 focus:ring-blue-500"
                    />
                    <span className="text-gray-700">Staff picks</span>
                  </label>
                </div>
              </div>
            </div>

            {/* Main Content */}
            <div className="flex-1">
              {/* Filters Bar */}
              <div className="flex items-center gap-2 mb-6 flex-wrap">
                <span className="text-gray-600">Cars & Vehicles</span>
                <span className="text-gray-400">-</span>
                <span className="text-gray-600">All time</span>
                <span className="text-gray-400">-</span>
                <span className="text-gray-600">Any</span>
                <span className="text-gray-400">-</span>
                <span className="text-gray-600">Downloadable</span>
                <span className="text-gray-400">-</span>
                <span className="text-gray-600">Animated</span>
                <span className="text-gray-400">-</span>
                <span className="text-gray-600">Staff picks</span>
                <span className="text-gray-400">-</span>
                <span className="text-blue-600 font-medium cursor-pointer">RESET</span>
              </div>

              {/* Models Grid */}
              <div className="grid gap-6">
                {demoModels.map(model => (
                  <div key={model.id} className="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                    <div className="flex">
                      {/* Model Preview */}
                      <div className="w-48 h-48 bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center relative">
                        <div className="text-center">
                          <div className="text-3xl mb-2">🚗</div>
                          <div className="text-sm text-gray-600">3D Preview</div>
                        </div>
                        {model.isStaffPick && (
                          <div className="absolute top-2 left-2 bg-yellow-500 text-white px-2 py-1 rounded text-xs font-bold">
                            Staff Pick
                          </div>
                        )}
                        {model.isFree && (
                          <div className="absolute top-2 right-2 bg-green-500 text-white px-2 py-1 rounded text-xs font-bold">
                            FREE
                          </div>
                        )}
                      </div>

                      {/* Model Info */}
                      <div className="flex-1 p-4">
                        <div className="flex justify-between items-start mb-2">
                          <h3 className="text-lg font-semibold text-gray-900">
                            {model.title}
                          </h3>
                          {!model.isFree && (
                            <span className="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm font-medium">
                              ${model.price}
                            </span>
                          )}
                        </div>
                        
                        <p className="text-gray-600 text-sm mb-3">{model.description}</p>
                        
                        <div className="flex items-center gap-6 text-sm text-gray-500 mb-3">
                          <span className="flex items-center gap-1">
                            <span className="text-yellow-500">🌟</span>
                            {(model.downloads / 1000).toFixed(1)}k
                          </span>
                          <span className="flex items-center gap-1">
                            <span className="text-red-500">❤️</span>
                            {model.likes}
                          </span>
                          <span className="flex items-center gap-1">
                            <span className="text-blue-500">💬</span>
                            {(model.downloads / 1000).toFixed(1)}k
                          </span>
                        </div>

                        <div className="flex items-center justify-between">
                          <div className="flex items-center gap-2">
                            <span className="text-xs text-gray-500">{model.license}</span>
                            <span className="text-xs text-gray-500">•</span>
                            <span className="text-xs text-gray-500">{model.polygonCount} polys</span>
                            <span className="text-xs text-gray-500">•</span>
                            <span className="text-xs text-gray-500">{model.fileFormat}</span>
                          </div>
                          <span className="text-xs text-gray-500">by {model.author}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}
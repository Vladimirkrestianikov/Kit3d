// app/mymodels/page.tsx
'use client'

import { useState } from 'react'

const myModels = [
  {
    id: 1,
    title: "Modern Living Room Set",
    description: "Complete living room furniture with realistic materials and textures",
    category: "Furniture",
    price: 34.99,
    rating: 4.8,
    downloads: 1247,
    likes: 89,
    views: 15600,
    author: "You",
    tags: ["modern", "livingroom", "furniture"],
    polygonCount: "85K",
    fileFormat: "FBX",
    isPublished: true,
    isFeatured: false,
    license: "Standard",
    createdAt: "2024-11-15",
    status: "published"
  },
  {
    id: 2,
    title: "Sci-Fi Weapon Pack",
    description: "Collection of futuristic weapons with detailed animations",
    category: "Weapons",
    price: 24.99,
    rating: 4.6,
    downloads: 876,
    likes: 45,
    views: 9800,
    author: "You",
    tags: ["scifi", "weapons", "futuristic"],
    polygonCount: "120K",
    fileFormat: "GLTF",
    isPublished: true,
    isFeatured: true,
    license: "Standard",
    createdAt: "2024-11-10",
    status: "published"
  },
  {
    id: 3,
    title: "Character Base Mesh",
    description: "Generic human base mesh with clean topology for character creation",
    category: "Characters",
    price: 0,
    rating: 4.7,
    downloads: 2156,
    likes: 156,
    views: 28700,
    author: "You",
    tags: ["character", "base", "human"],
    polygonCount: "25K",
    fileFormat: "BLEND",
    isPublished: true,
    isFeatured: false,
    license: "CC BY",
    createdAt: "2024-11-05",
    status: "published"
  },
  {
    id: 4,
    title: "Fantasy Environment",
    description: "Magical forest environment with animated foliage and lighting",
    category: "Environments",
    price: 45.99,
    rating: 4.9,
    downloads: 543,
    likes: 67,
    views: 12300,
    author: "You",
    tags: ["fantasy", "environment", "magical"],
    polygonCount: "250K",
    fileFormat: "GLTF",
    isPublished: true,
    isFeatured: true,
    license: "Standard",
    createdAt: "2024-11-01",
    status: "published"
  },
  {
    id: 5,
    title: "Low Poly Animals",
    description: "Stylized low poly animal characters for mobile games",
    category: "Characters",
    price: 18.99,
    rating: 4.5,
    downloads: 765,
    likes: 34,
    views: 8900,
    author: "You",
    tags: ["lowpoly", "animals", "stylized"],
    polygonCount: "8K",
    fileFormat: "FBX",
    isPublished: true,
    isFeatured: false,
    license: "Standard",
    createdAt: "2024-10-28",
    status: "published"
  },
  {
    id: 6,
    title: "Cyberpunk City Block",
    description: "WIP - Urban environment with neon signs and futuristic architecture",
    category: "Architecture",
    price: 0,
    rating: 0,
    downloads: 0,
    likes: 0,
    views: 120,
    author: "You",
    tags: ["cyberpunk", "wip", "city"],
    polygonCount: "180K",
    fileFormat: "BLEND",
    isPublished: false,
    isFeatured: false,
    license: "None",
    createdAt: "2024-11-17",
    status: "draft"
  },
  {
    id: 7,
    title: "Vehicle Pack Collection",
    description: "Various vehicle models including cars, trucks, and motorcycles",
    category: "Vehicles",
    price: 39.99,
    rating: 4.8,
    downloads: 987,
    likes: 78,
    views: 14500,
    author: "You",
    tags: ["vehicles", "pack", "collection"],
    polygonCount: "95K",
    fileFormat: "OBJ",
    isPublished: true,
    isFeatured: false,
    license: "Standard",
    createdAt: "2024-10-20",
    status: "published"
  }
]

export default function MyModelsPage() {
  const [selectedCategory, setSelectedCategory] = useState('all')
  const [selectedStatus, setSelectedStatus] = useState('all')
  const [selectedLicense, setSelectedLicense] = useState('any')
  const [searchQuery, setSearchQuery] = useState('')

  const categories = [
    { value: 'all', label: 'All Categories' },
    { value: 'Furniture', label: 'Furniture' },
    { value: 'Weapons', label: 'Weapons' },
    { value: 'Characters', label: 'Characters' },
    { value: 'Environments', label: 'Environments' },
    { value: 'Architecture', label: 'Architecture' },
    { value: 'Vehicles', label: 'Vehicles' }
  ]

  const statuses = [
    { value: 'all', label: 'All Status' },
    { value: 'published', label: 'Published' },
    { value: 'draft', label: 'Draft' },
    { value: 'featured', label: 'Featured' }
  ]

  const licenses = [
    { value: 'any', label: 'Any' },
    { value: 'Standard', label: 'Standard' },
    { value: 'CC BY', label: 'CC BY' },
    { value: 'None', label: 'None' }
  ]
  const filteredModels = myModels.filter(model => {
    const categoryMatch = selectedCategory === 'all' || model.category === selectedCategory
    const statusMatch = selectedStatus === 'all' || 
      (selectedStatus === 'published' && model.status === 'published') ||
      (selectedStatus === 'draft' && model.status === 'draft') ||
      (selectedStatus === 'featured' && model.isFeatured)
    const licenseMatch = selectedLicense === 'any' || model.license === selectedLicense
    const searchMatch = model.title.toLowerCase().includes(searchQuery.toLowerCase()) ||
                       model.description.toLowerCase().includes(searchQuery.toLowerCase())
    
    return categoryMatch && statusMatch && licenseMatch && searchMatch
  })

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <div className="bg-white border-b border-gray-200">
        <div className="container mx-auto px-4 py-6">
          <div className="flex items-center justify-between mb-6">
            <div>
              <h1 className="text-2xl font-bold text-gray-900">My Models</h1>
              <p className="text-gray-600 mt-1">Manage and track your 3D model portfolio</p>
            </div>
            <div className="flex items-center gap-4">
              <div className="relative">
                <input
                  type="text"
                  placeholder="Search my models..."
                  value={searchQuery}
                  onChange={(e) => setSearchQuery(e.target.value)}
                  className="w-80 px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                />
                <div className="absolute left-3 top-2.5 text-gray-400">
                  🔍
                </div>
              </div>
              <button className="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                Upload New
              </button>
            </div>
          </div>

          <div className="flex gap-6">
            {/* Left Sidebar */}
            <div className="w-64 space-y-6">
              {/* Quick Stats */}
              <div className="bg-blue-50 rounded-lg p-4">
                <h3 className="font-semibold text-blue-900 mb-3">Portfolio Stats</h3>
                <div className="space-y-2 text-sm">
                  <div className="flex justify-between">
                    <span className="text-blue-700">Total Models:</span>
                    <span className="font-semibold">{myModels.length}</span>
                  </div>
                  <div className="flex justify-between">
                    <span className="text-blue-700">Published:</span>
                    <span className="font-semibold">{myModels.filter(m => m.isPublished).length}</span>
                  </div>
                  <div className="flex justify-between">
                    <span className="text-blue-700">Total Downloads:</span>
                    <span className="font-semibold">{myModels.reduce((acc, m) => acc + m.downloads, 0).toLocaleString()}</span>
                  </div>
                  <div className="flex justify-between">
                    <span className="text-blue-700">Total Earnings:</span>
                    <span className="font-semibold text-green-600">
                      ${myModels.reduce((acc, m) => acc + (m.price * m.downloads), 0).toFixed(2)}
                    </span>
                  </div>
                </div>
              </div>

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
                <h3 className="font-semibold text-gray-900 mb-3">STATUS</h3>
                <div className="space-y-2">
                  {statuses.map(status => (
                    <label key={status.value} className="flex items-center space-x-2 cursor-pointer">
                      <input
                        type="radio"
                        name="status"
                        value={status.value}
                        checked={selectedStatus === status.value}
                        onChange={(e) => setSelectedStatus(e.target.value)}
                        className="text-blue-600 focus:ring-blue-500"
                      />
                      <span className="text-gray-700">{status.label}</span>
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
                <h3 className="font-semibold text-gray-900 mb-3">ACTIONS</h3>
                <div className="space-y-2">
                  <button className="w-full text-left text-blue-600 hover:text-blue-700 text-sm py-1">
                    Bulk Edit
                  </button>
                  <button className="w-full text-left text-blue-600 hover:text-blue-700 text-sm py-1">
                    Export Data
                  </button>
                  <button className="w-full text-left text-red-600 hover:text-red-700 text-sm py-1">
                    Delete Selected
                  </button>
                </div>
              </div>
            </div>

            {/* Main Content */}
            <div className="flex-1">
              {/* Filters Bar */}
              <div className="flex items-center gap-2 mb-6 flex-wrap">
                <span className="text-gray-600">Showing {filteredModels.length} of {myModels.length} models</span>
                <span className="text-gray-400">•</span>
                {selectedCategory !== 'all' && (
                  <>
                    <span className="text-gray-600">{selectedCategory}</span>
                    <span className="text-gray-400">•</span>
                  </>
                )}
                {selectedStatus !== 'all' && (
                  <>
                    <span className="text-gray-600">{selectedStatus}</span>
                    <span className="text-gray-400">•</span>
                  </>
                )}
                {selectedLicense !== 'any' && (
                  <>
                    <span className="text-gray-600">{selectedLicense}</span>
                    <span className="text-gray-400">•</span>
                  </>
                )}
                <span className="text-blue-600 font-medium cursor-pointer" onClick={() => {
                  setSelectedCategory('all')
                  setSelectedStatus('all')
                  setSelectedLicense('any')
                  setSearchQuery('')
                }}>
                  RESET
                </span>
              </div>

              {/* Models Grid */}
              <div className="grid gap-4">
                {filteredModels.map(model => (
                  <div key={model.id} className="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                    <div className="flex">
                      {/* Model Preview */}
                      <div className="w-48 h-48 bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center relative">
                        <div className="text-center">
                          <div className="text-3xl mb-2">🎮</div>
                          <div className="text-sm text-gray-600">3D Preview</div>
                        </div>
                        {model.isFeatured && (
                          <div className="absolute top-2 left-2 bg-yellow-500 text-white px-2 py-1 rounded text-xs font-bold">
                            Featured
                          </div>
                        )}
                        {model.status === 'draft' && (
                          <div className="absolute top-2 left-2 bg-gray-500 text-white px-2 py-1 rounded text-xs font-bold">
                            Draft
                          </div>
                        )}
                        {model.price === 0 ? (
                          <div className="absolute top-2 right-2 bg-green-500 text-white px-2 py-1 rounded text-xs font-bold">
                            FREE
                          </div>
                        ) : (
                          <div className="absolute top-2 right-2 bg-blue-500 text-white px-2 py-1 rounded text-xs font-bold">
                            ${model.price}
                          </div>
                        )}
                      </div>

                      {/* Model Info */}
                      <div className="flex-1 p-4">
                        <div className="flex justify-between items-start mb-2">
                          <div>
                            <h3 className="text-lg font-semibold text-gray-900">
                              {model.title}
                            </h3>
                            <p className="text-gray-600 text-sm mt-1">{model.description}</p>
                          </div>
                          <div className="flex gap-2">
                            <button className="text-gray-400 hover:text-gray-600 p-1">
                              ✏️
                            </button>
                            <button className="text-gray-400 hover:text-gray-600 p-1">
                              ⚙️
                            </button>
                            <button className="text-gray-400 hover:text-red-600 p-1">
                              🗑️
                            </button>
                          </div>
                        </div>
                        
                        <div className="flex items-center gap-6 text-sm text-gray-500 mb-3">
                          <span className="flex items-center gap-1">
                            <span className="text-yellow-500">🌟</span>
                            {(model.views / 1000).toFixed(1)}k
                          </span>
                          <span className="flex items-center gap-1">
                            <span className="text-red-500">❤️</span>
                            {model.likes}
                          </span>
                          <span className="flex items-center gap-1">
                            <span className="text-blue-500">⬇️</span>
                            {(model.downloads / 1000).toFixed(1)}k
                          </span>
                          <span className="flex items-center gap-1">
                            <span className="text-purple-500">⭐</span>
                            {model.rating || 'N/A'}
                          </span>
                        </div>

                        <div className="flex items-center justify-between">
                          <div className="flex items-center gap-2">
                            <span className={`px-2 py-1 rounded text-xs font-medium ${
                              model.status === 'published' ? 'bg-green-100 text-green-800' :
                              model.status === 'draft' ? 'bg-gray-100 text-gray-800' :
                              'bg-blue-100 text-blue-800'
                            }`}>
                              {model.status}
                            </span>
                            <span className="text-xs text-gray-500">{model.license}</span>
                            <span className="text-xs text-gray-500">•</span>
                            <span className="text-xs text-gray-500">{model.polygonCount} polys</span>
                            <span className="text-xs text-gray-500">•</span>
                            <span className="text-xs text-gray-500">{model.fileFormat}</span>
                            <span className="text-xs text-gray-500">•</span>
                            <span className="text-xs text-gray-500">{model.createdAt}</span>
                          </div>
                          <span className="text-xs text-gray-500">{model.category}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                ))}
              </div>

              {filteredModels.length === 0 && (
                <div className="text-center py-12">
                  <div className="text-6xl mb-4">🎭</div>
                  <h3 className="text-xl font-semibold text-gray-900 mb-2">No models found</h3>
                  <p className="text-gray-600 mb-6">Try changing your filters or upload a new model</p>
                  <button className="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                    Upload Your First Model
                  </button>
                </div>
              )}
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}
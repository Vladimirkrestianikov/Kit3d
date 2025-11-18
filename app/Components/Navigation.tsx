import { SignedIn, SignedOut, SignInButton, UserButton, SignOutButton } from "@clerk/nextjs";
import { ruRU } from "@clerk/localizations";

export const Navigation = () => {
  return (
    <nav className="bg-white border-b border-orange-200 px-6 py-4">
      <div className="max-w-7xl mx-auto flex items-center justify-between">
        {/* Логотип */}
        <div className="flex items-center space-x-2">
          <div className="w-8 h-8 bg-gradient-to-br from-orange-500 to-green-500 rounded-lg flex items-center justify-center">
            <div className="w-3 h-3 bg-white rounded-full"></div>
          </div>
          <span className="text-2xl font-bold text-gray-900 tracking-tight">
            Kit3D
          </span>
        </div>

        {/* Навигационные ссылки */}
        <div className="hidden md:flex items-center space-x-8">
          <a 
            href="/allmodels" 
            className="text-gray-700 hover:text-orange-500 transition-colors duration-200 font-medium"
          >
           Все Модели
          </a>


          <a 
            href="/mymodels" 
            className="text-gray-700 hover:text-green-500 transition-colors duration-200 font-medium"
          >
            Мои Модели
          </a>
         
          <a 
            href="/About" 
            className="text-gray-700 hover:text-green-500 transition-colors duration-200 font-medium"
          >
            О нас
          </a>
          
        </div>

        {/* Кнопки авторизации */}
        <div className="flex items-center space-x-4">
          {/* Для неавторизованных пользователей - кнопка Войти */}
          <SignedOut>
            <SignInButton mode="modal">
              <button className="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 font-medium">
                Войти
              </button>
            </SignInButton>
          </SignedOut>

          {/* Для авторизованных пользователей - UserButton и кнопка Выйти */}
          <SignedIn>
            <div className="flex items-center space-x-4">
              <UserButton 
                afterSignOutUrl="/"
                appearance={{
                  elements: {
                    avatarBox: "w-10 h-10"
                  }
                }}
              />
              <SignOutButton>
                <button className="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition-colors duration-200 font-medium">
                  Выйти
                </button>
              </SignOutButton>
            </div>
          </SignedIn>
        </div>
      </div>
    </nav>
  );
};
<header class="border-t-8 border-blue pt-8 mb-8">
    <div class="container mx-auto px-4 md:px-0 lg:px-0">
        <div class="text-center md:text-left lg:text-left">
            <a href="{{ route('home') }}">
                <img 
                    class="rounded-full mb-3 shadow-avatar" 
                    src="https://www.gravatar.com/avatar/{{ md5('james@jamesoneill.eu') }}?s=80"
                >
            </a>
        </div>

        <nav class="border-b border-grey font-bold no-underline text-lg">
            <ul class="flex list-reset">
                @component('components.nav-item', ['url' => route('home')])
                    Home
                @endcomponent

                @component('components.nav-item', ['url' => route('blog')])
                    Blog
                @endcomponent

                @component('components.nav-item', ['url' => route('talks')])
                    Talks
                @endcomponent
            </ul>
        </nav>
    </div>
</header>
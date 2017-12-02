<li>
    <a class="-mb-px border-b {{ url()->current() == $url ? 'border-blue-dark' : 'border-transparent' }} inline-block px-4 py-4 text-blue hover:no-underline hover:border-blue-dark" href="{{ $url or '#' }}">
        {{ $slot }}
    </a>
</li>
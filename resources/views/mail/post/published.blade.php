@component('mail::message')
# Hey

You signed up to be notified whenever I posted a new blog article.

I've just posted a new article called {{ $post->title }}. I hope you find it interesting.

@component('mail::button', ['url' => $post->url()])
Read Now
@endcomponent

Cheers,<br>
James
@endcomponent

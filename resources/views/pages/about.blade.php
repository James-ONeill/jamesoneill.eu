@extends('layouts.master')

@section('content')
    <div>
        <h1 class="page-title text-center">About Me</h1>

        <p>I'm a software developer from Bristol, England.</p>

        <p>
            Day to day I mostly work with Laravel and React. This is my first go at a
            personal site and I'm not quite sure what I'm going to do with it yet.
        </p>

        <p>
            If you want to say hi why not follow me on
            <a href="https://twitter.com/jamesoneill83">Twitter</a> or you can drop
            me an email at <a href="mailto:james@jamesoneill.eu">james@jamesoneill.eu</a>.
            Also you could <a href="https://www.facebook.com/ambertibetanterrier/">like my Dog on Facebook.</a>
        </p>
    </div>
    {{--<div>
        <h1 class="page-title text-center">About This Site</h1>

        <p>
            At the time of writing this site is still a work in progress, if
            you're interested in the source code you can check it out on
            <a href="https://github.com/James-ONeill/jamesoneill.eu">GitHub</a>.
            Inspired by <a href="http://wesbos.com/uses">Wes Bos' "Uses" page</a>
            I want to use this section as a living document to explain how I have
            put the site together and why I made the decisions I did.
        </p>

        <h4>Philosophy</h4>

        <p>
            My aim is to make small code changes that I deploy frequently. I
            started out with a static home page with minimal and all changes from
            there have been in tiny increments.
        </p>

        <h4>Back End</h4>

        <p>
            The back end of the site is built in Laravel. I was originally going
            to try and build it in Ruby on Rails since I've really liked Ruby's
            syntax whenever I've gotten the chance to use the language. I
            changed my mind because this is a project I'm working on in my spare
            time and my familiarity with Laravel means I can focus more on
            content than I would do if I were using a tech stack that I've not
            built projects in before.
        </p>

        <h4>Blog Posts</h4>

        <p>
            My original intention was to have the site read blog posts from
            markdown documents, mostly because I prefer the idea of writing
            markdown in Sublime Text than writing in a back end editor. The very
            first version of the site used this methodology to display a single
            blog post
        </p>
    </div>--}}
@endsection
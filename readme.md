## About jamesoneill.eu

This is the source code for my personal website and blog, which can be found at
[jamesoneill.eu](https://jamesoneill.eu). The site is built using Laravel, with
all the posts available in Markdown in the `/resources/posts` directory.

## Posts (Updated 1/4/2017)

The first post was stored in a markdown document. This is how I had planned to
manage all posts because I like the workflow of writing them in my chosen text
editor and having them under version control.

Since this involves throwing away all of the functionality that comes with
Eloquent it seems this is unworkable as a long term approach. I have decided to
shelve this option for now and create a `Post` model. In the future I intend to
consider a hybrid approach whereby saving a post creates a markdown document and
commits it and the application picks up on post files that don't have a related
model and creates one for them.

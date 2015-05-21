@extends('layouts.master')

@section('title')
	About
@stop

@section('content')
	<div class="col-md-6 col-md-offset-3">
		<h1 style="margin-top:0">About</h1>
		<hr />
		<p class="lead">
			<strong>Redditing</strong> is a <a href="https://reddit.com" target="_blank" rel="nofollow"><strong>reddit</strong></a> browser made to simplify browsing reddit using various API's and visual improvements.
		    <br />
		    <br />
		    Redditing began as a weekend project of mine and has since changed into website with, at the time of writing this, <strong>10 000+</strong> unique of visitors every day. I am very happy that people like what I've created and I try to improve Redditing every day.
	    </p>

	    <h3>About the Author</h3>
	    <hr />
	    <p class="lead">
	    	My name is <a href="http://filiphajek.com/"><strong>Filip Hajek</strong></a> and I am a 19 year old student living in Europe. My hobbies are creating websites and playing video games.
	    	<br />
	    	<br />
	    	If you'd like to contact me, do so either by sending me a private message on reddit (<a href="https://www.reddit.com/message/compose/?to=Epick_362">Epick_362</a>) or send me an email to: {{ HTML::mailto('flp.hajek@gmail.com') }}.
	    </p>
    </div>
@stop

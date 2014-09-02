
<div class="col-md-2" style="position:fixed; top:120px">
	@if($subreddit)
	<div class="sidebar panel panel-default">
		<div class="panel-body">
			{{ $subreddit }} <br />
			@if(Session::has('user'))
			<a href="" class="btn btn-default">Subscribe</a>
			@endif
		</div>
	</div>
	@endif
	<div class="sidebar panel panel-default">
		<div class="panel-heading">
			Popular subreddits
		</div>
		<div class="panel-body">
			<a href="http://readditing.com/r/funny">funny</a><br>
			<a href="http://readditing.com/r/AdviceAnimals">AdviceAnimals</a><br>
			<a href="http://readditing.com/r/pics">pics</a><br>
			<a href="http://readditing.com/r/aww">aww</a><br>
			<a href="http://readditing.com/r/todayilearned">todayilearned</a><br>
			<a href="http://readditing.com/r/videos">videos</a><br>
			<a href="http://readditing.com/r/WTF">WTF</a><br>
			<a href="http://readditing.com/r/gifs">gifs</a><br>
			<a href="http://readditing.com/r/gaming">gaming</a><br>
			<a href="http://readditing.com/r/leagueoflegends">leagueoflegends</a><br>
			<a href="http://readditing.com/r/worldnews">worldnews</a><br>
			<a href="http://readditing.com/r/AskReddit">AskReddit</a><br>
			<a href="http://readditing.com/r/TheLastAirbender">TheLastAirbender</a><br>
			<a href="http://readditing.com/r/trees">trees</a><br>
			<a href="http://readditing.com/r/4chan">4chan</a><br>
			<a href="http://readditing.com/r/pcmasterrace">pcmasterrace</a><br>
			<a href="http://readditing.com/r/reactiongifs">reactiongifs</a><br>
			<a href="http://readditing.com/r/news">news</a><br>
			<a href="http://readditing.com/r/TrollXChromosomes">TrollXChromosomes</a><br>
			<a href="http://readditing.com/r/mildlyinteresting">mildlyinteresting</a><br>
			<a href="http://readditing.com/r/politics">politics</a><br>
			<a href="http://readditing.com/r/DotA2">DotA2</a><br>
			<a href="http://readditing.com/r/soccer">soccer</a><br>
			<a href="http://readditing.com/r/Showerthoughts">Showerthoughts</a><br>
			<a href="http://readditing.com/r/pokemon">pokemon</a><br>
		</div>
	</div>
</div>
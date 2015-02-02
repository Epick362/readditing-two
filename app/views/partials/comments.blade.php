@if(Session::has('user'))
<li class="media list-unstyled">
	<div class="media-body">
		<h4 class="media-heading" style="margin-bottom:10px;"><a href="">{{ $username }}</a></h4>
		<form ng-submit="reply(post, 't3')">
    		<div class="form-group">
    			<textarea class="form-control" msd-elastic placeholder="Contribute to discussion..." ng-model="post.reply" rows="2"></textarea>
    			<button style="margin-top:10px" class="btn btn-primary btn-sm pull-right">Send</button>
    		</div>
		</form>
	</div>
</li>

<hr />
@endif

<div ng-show="post.comments > 0">
    <ul class="media-list" infinite-scroll='reddit.getComments(post.name)' infinite-scroll-disabled='reddit.busy' infinite-scroll-distance='1'>
		<li ng-if="reddit.comments.length > 0" class="media" ng-repeat="comment in reddit.comments" ng-include="'comment.html'"></li>
	</ul>

	<!-- LOADING =============================================== -->
	<div class="loading" ng-show="reddit.busy && reddit.comments.length == 0">
		<div class="ball-outer"></div>
		<div class="ball-inner"></div>
	</div>
</div>

<div ng-if="!post.comments">
	<ul class="media-list"></ul>
</div>

<div ng-show="!post.comments" class="alert alert-info">There doesn't seem to be anything here...</div>
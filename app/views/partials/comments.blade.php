<div ng-show="post.comments > 0">
    <ul class="media-list" infinite-scroll='reddit.getComments(post.id)' infinite-scroll-disabled='reddit.busy' infinite-scroll-distance='1'>
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


<div class="modal-header">
	<button type="button" class="close" ng-click="cancel()"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h3 class="modal-title"><% post.title %></h3>
</div>
<div class="modal-body">
	<a href="" class="btn btn-link btn-xs" reply-form="post">Reply</a>
	<a ng-if="!post.saved" href="" class="btn btn-link btn-xs" ng-click="save(post, 't3', 1)">Save</a>
	<a ng-if="post.saved" href="" class="btn btn-link btn-xs active" ng-click="save(post, 't3', 0)">Unsave</a>
	<a class="btn btn-link btn-xs" href="https://www.reddit.com/gold?goldtype=gift&amp;months=1&amp;thing=t3_<% post.id %>" target="_blank">Give Gold</a>
</div>
<div class="modal-footer">
	<div ng-show="post.comments > 0">
	    <ul class="media-list" infinite-scroll='reddit.getComments(post.id)' infinite-scroll-disabled='reddit.busy' infinite-scroll-distance='1'>
			<li ng-if="reddit.comments.length > 0" class="media" ng-repeat="comment in reddit.comments" ng-include="'comment.html'"></li>
		</ul>

		<!-- LOADING =============================================== -->
		<div class="spinner" ng-show="reddit.busy && reddit.comments.length == 0">
			<div class="bounce1"></div>
			<div class="bounce2"></div>
		</div>
	</div>

	<div ng-if="!post.comments">
		<ul class="media-list"></ul>
	</div>

	<div ng-show="!post.comments" class="alert alert-info">There doesn't seem to be anything here...</div>
</div>
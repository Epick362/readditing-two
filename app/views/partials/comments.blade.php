
<div class="modal-header">
	<button type="button" class="close" ng-click="cancel()"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h3 class="modal-title"><% post.title %></h3>
</div>
<div class="modal-body">
	<a href="" class="btn btn-default btn-block" ng-click="reply(post, 't1')">Reply</a>
    <ul class="media-list" infinite-scroll='reddit.getComments(post.id)' infinite-scroll-disabled='reddit.busy' infinite-scroll-distance='1'>
		<li class="media" ng-repeat="comment in reddit.comments" ng-include="'comment.html'"></li>
	</ul>

	<!-- LOADING =============================================== -->
	<div class="loading" ng-show="reddit.busy">
		<div class="ball-outer"></div>
		<div class="ball-inner"></div>
	</div>
</div>

<div class="modal-header">
	<button type="button" class="close" ng-click="cancel()"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h3 class="modal-title"><% post.title %></h3>
</div>
<div class="modal-body">
    <ul class="media-list" infinite-scroll='reddit.getComments(post.id)' infinite-scroll-disabled='reddit.busy' infinite-scroll-distance='1'>
		<div ng-repeat="comment in reddit.comments" ng-include="'comment_tree.html'"></div>
	</ul>

	<!-- LOADING =============================================== -->
	<div class="loading" ng-show="reddit.busy">
		<div class="ball-outer"></div>
		<div class="ball-inner"></div>
	</div>
</div>
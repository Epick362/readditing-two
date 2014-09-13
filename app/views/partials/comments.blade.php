
<div class="modal-header">
	<button type="button" class="close" ng-click="cancel()"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h3 class="modal-title"><% post.title %></h3>
</div>
<div class="modal-body">
	<ul class="media-list">
	    <div infinite-scroll='reddit.getComments(post.id)' infinite-scroll-disabled='reddit.busy' infinite-scroll-distance='1'>
			<li class="media" ng-repeat="comment in reddit.comments">
				<a class="pull-left" href="#"><img class="media-object" src="http://placehold.it/64x64"></a>
				<div class="media-body">
					<h4 class="media-heading"><a href="#"><% comment.author %></a> <small><i class="fa fa-arrow-up"></i> <% comment.score %></small></h4>
					<div ng-bind-html="comment.body"></div>
				</div>
			</li>
		</div>
	</ul>

	<!-- LOADING =============================================== -->
	<div class="loading" ng-show="reddit.busy">
		<div class="ball-outer"></div>
		<div class="ball-inner"></div>
	</div>
</div>
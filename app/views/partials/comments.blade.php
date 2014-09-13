
<div class="modal-header">
    <h3 class="modal-title"><% post.title %></h3>
</div>
<div class="modal-body">
    <div infinite-scroll='reddit.getComments(post.id)' infinite-scroll-disabled='reddit.busy' infinite-scroll-distance='1'>
		<li ng-repeat="comment in reddit.comments">
			<% comment.body %>
			<hr />
		</li>
	</div>

	<!-- LOADING =============================================== -->
	<div class="loading" ng-show="reddit.busy">
		<div class="ball-outer"></div>
		<div class="ball-inner"></div>
	</div>
</div>
<div class="modal-footer">
    <button class="btn btn-warning btn-block" ng-click="cancel()">Cancel</button>
</div>
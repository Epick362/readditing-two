<div class="media-body">
	<h4 class="media-heading"><a href="#"><% comment.author %></a> <small class="text-alternate"><i class="fa fa-arrow-up"></i> <% comment.score %></small></h4>
	<div ng-bind-html="comment.body"></div>
	@if(Session::has('user'))
	<div>
		<a href="#">Reply</a>
		<span ng-if="!comment.saved">
			<a ng-click="save(comment, 't1', 1)">Save</a>
		</span>
		<span ng-if="comment.saved">
			<a class="active" ng-click="save(comment, 't1', 0)">Unsave</a>
		</span>
		<a href="#">Report</a>
		<a href="#">Give Gold</a>
	</div>
	@endif
	<div ng-if="comment.replies.length > 0" class="media" ng-repeat="comment in comment.replies" ng-include="'comment.html'"></div>
</div>
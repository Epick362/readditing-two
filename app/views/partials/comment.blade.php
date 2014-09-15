<div class="media-body">
	<div class="pull-right visible-lg visible-md"><small class="text-muted" am-time-ago="comment.created" am-preprocess="unix"></small></div>
	<h4 class="media-heading"><a href="#"><% comment.author %></a> <small class="text-alternate"><i class="fa fa-arrow-up"></i> <% comment.score %></small></h4>
	<div class="clearfix"></div>
	<div ng-bind-html="comment.body"></div>
	@if(Session::has('user'))
	<div>
		<a class="btn btn-link btn-xs" href="#">Reply</a>
		<span ng-if="!comment.saved">
			<a href="" class="btn btn-link btn-xs" ng-click="save(comment, 't1', 1)">Save</a>
		</span>
		<span ng-if="comment.saved">
			<a href="" class="btn btn-link btn-xs active" ng-click="save(comment, 't1', 0)">Unsave</a>
		</span>
		<a class="btn btn-link btn-xs" href="https://www.reddit.com/gold?goldtype=gift&amp;months=1&amp;thing=t1_<% comment.id %>" target="_blank">Give Gold</a>
	</div>
	@endif
	<div ng-if="comment.replies.length > 0" class="media" ng-repeat="comment in comment.replies" ng-include="'comment.html'"></div>
</div>
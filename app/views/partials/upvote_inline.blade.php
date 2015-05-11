<div class="panel-body ng-cloak hidden-lg hidden-md" ng-if="post.author">
	<div class="row">
		<div class="col-xs-12 text-center">
			@if(Session::has('user'))
			<span ng-if="!post.likes">
				<a href="" class="btn btn-upvote btn-xs" ng-click="vote(post, 't3', 1)" analytics-on analytics-category="Upvote" analytics-label="Up"><i class="fa fa-arrow-up"></i></a>
				<small class="text-alternate"><% post.score %> upvotes</small>
			</span>
			<span ng-if="post.likes">
				<a href="" class="btn btn-upvote btn-xs active" ng-click="vote(post, 't3', 0)" analytics-on analytics-category="Upvote" analytics-label="Un"><i class="fa fa-arrow-up"></i></a>
				<small class="text-alternate"><% post.score %> upvotes</small>
			</span>		
			@else	
				<small class="text-alternate"><i class="fa fa-arrow-up"></i> <% post.score %> upvotes</small>
			@endif
		</div>
	</div>
</div>
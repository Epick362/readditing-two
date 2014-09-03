	<div id="posts" infinite-scroll='reddit.nextPage()' infinite-scroll-disabled='reddit.busy' infinite-scroll-distance='1'>
		<div class="panel panel-default" show-more data-extra="<% post.extra %>" ng-repeat="post in reddit.posts">
			<div class="upvote-wrapper">
				<figure class="upvote upvoteable">
					<a class="upvoteobject">
						<div class="opening">
							<div class="circle"><div class="inner-circle"><i class="fa fa-arrow-up"></i></div></div>
						</div>
					</a>

					<a href="#upvote" class="count">
						<span class="num">3882</span>
						<span class="txt">Upvotes</span>
					</a>
				</figure>
			</div>
			<div class="panel-heading">
				<% post.title %>
				<a class="pull-right" href="<% post.url %>" target="_blank" rel="nofollow"><% post.source %></a>
				<div class="clearfix"></div>
			</div>
			<div class="panel-body" ng-bind-html="post.content">
			</div>
			<div class="panel-footer" ng-if="post.author">
				<div class="row">
					<div class="col-sm-4">
						<a href=""><% post.author %></a> in <a href="{{ URL::to('r') }}/<% post.subreddit %>"><% post.subreddit %></a> 
					</div>
					<div class="col-sm-4 text-center">
						<a href="#" class="btn-showcomments"><i class="fa fa-comment-o"></i> <% post.comments %> comments</a>
					</div>
					@if(Session::has('user'))
					<div class="col-sm-4 text-right">
						<a href="" tooltip="Save"><i class="fa fa-save"></i></a>
						<a href="" tooltip="Report"><i class="fa fa-flag"></i></a>
						<a href="" tooltip="Hide"><i class="fa fa-eye"></i></a>		
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>


	<!-- LOADING =============================================== -->
	<div class="loading" ng-show="reddit.busy">
		<div class="ball-outer"></div>
		<div class="ball-inner"></div>
	</div>
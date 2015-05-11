	<div infinite-scroll="{{ $function or 'reddit.nextPage()' }}" infinite-scroll-disabled='reddit.busy' infinite-scroll-distance='1'>
		<div class="panel panel-default" ng-class="(post.nsfw) ? 'nsfw' : ''" ng-repeat="post in reddit.posts">
			
			@include('partials.upvote_aside')

			<div class="panel-heading">
				<a class="title" href="{{ URL::to('r') }}/<% post.channel %>/comments/<% post.name %>" target="_blank"><% post.title %></a>
				<a class="pull-right source" href="<% post.url %>" target="_blank" rel="nofollow"><% post.source %></a>
				<div class="clearfix"></div>
			</div>
			<div ng-show="post.nsfw && !nsfw" class="panel-body">
				<a href="" ng-click="setNSFW()" class="nsfw" analytics-on analytics-category="NSFW" analytics-label="Turn on">
					<div class="title">&nbsp;NSFW</div>
					Click to show
				</a>
			</div>
			<div ng-show="!post.nsfw || nsfw" class="panel-body" show-more ng-bind-html="post.content">

			</div>

			@include('partials.upvote_inline')

			<div class="panel-footer" ng-if="post.author">
				<div class="row">
					<div class="col-xs-4">
						<span ng-if="post.channel == channel">
							By 
							<a ng-href="{{ URL::to('u') }}/<% post.author %>">
								<% post.author %>
							</a> 
						</span>
						<span ng-if="post.channel != channel">
							<a href="{{ URL::to('r') }}/<% post.channel %>">
								<% post.channel %> 
							</a>
						</span>
					</div>
					<div class="col-xs-4 text-center">
						<a href="{{ URL::to('r') }}/<% post.channel %>/comments/<% post.name %>#comments" target="_blank" analytics-on analytics-category="Load Comments"><i class="fa fa-comment"></i> <% post.comments %> comments</a>
					</div>
					<div class="col-xs-4 text-right">
						<!--<span am-time-ago="post.created" am-preprocess="unix"></span> -->

						<!-- Facebook Share Button -->
						<a class="btn btn-share btn-sm facebook" analytics-on analytics-event="Share" analytics-category="Facebook" href="http://www.facebook.com/sharer/sharer.php?u={{ URL::to('r') }}/<% post.channel %>/comments/<% post.name %>&title=<% post.title %>" 
						onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-facebook"></i></a> 

						<!-- Twitter Share Button -->
						<a class="btn btn-share btn-sm twitter" analytics-on analytics-event="Share" analytics-category="Twitter" href="http://twitter.com/home?status=<% post.title %>+{{ URL::to('r') }}/<% post.channel %>/comments/<% post.name %>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-twitter"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div ng-show="reddit.busy">
		@include('partials.loading')
	</div>
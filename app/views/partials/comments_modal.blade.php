
<div class="modal-header">
	<button type="button" class="close" ng-click="cancel()"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h3 class="modal-title"><% post.title %></h3>
</div>
<div class="modal-body clearfix">
	<a href="" class="btn btn-primary btn-xs" reply-form="post">Reply</a>
	<a ng-if="!post.saved" href="" class="btn btn-primary btn-xs" ng-click="save(post, 't3', 1)">Save</a>
	<a ng-if="post.saved" href="" class="btn btn-link btn-xs active" ng-click="save(post, 't3', 0)">Unsave</a>
	<a class="btn btn-primary btn-xs" href="https://www.reddit.com/gold?goldtype=gift&amp;months=1&amp;thing=t3_<% post.id %>" target="_blank">Give Gold</a>
	<div class="pull-right">
		Share to: 
		<a 
			class="btn btn-share facebook btn-xs" 
			href="http://www.facebook.com/sharer/sharer.php?u={{ URL::to('r') }}/<% post.subreddit %>/comments/<% post.id %>&title=<% post.title %>" 
			onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"
		>
			<i class="fa fa-facebook-square"></i> Facebook
		</a> 
		<a 
			class="btn btn-share twitter btn-xs" 
			href="http://twitter.com/home?status=<% post.title %>+{{ URL::to('r') }}/<% post.subreddit %>/comments/<% post.id %>" 
			onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"
		>
			<i class="fa fa-twitter"></i> Twitter
		</a>
		<a 
			class="btn btn-share google-plus btn-xs" 
			href="https://plus.google.com/share?url={{ URL::to('r') }}/<% post.subreddit %>/comments/<% post.id %>" 
			onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"
		>
			<i class="fa fa-google-plus-square"></i> Google+
		</a>
	</div>
</div>
<div class="modal-footer" ng-include="'comments.html'"></div>
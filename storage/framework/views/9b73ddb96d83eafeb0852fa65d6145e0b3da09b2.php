 <?php $__env->startSection('title', 'Posts'); ?> <?php $__env->startSection('contents'); ?> <a href="<?php echo e(route('posts_create')); ?>" class="new-btn" title="New post"><i class="glyphicon glyphicon-pencil"></i></a> <div class="bg-light lter b-b wrapper-md"> <h1 class="m-n font-thin h3">Post</h1> <small class="text-muted">With posts, users will feel closer to your business.</small> </div> <div class="wrapper-md"> <div class="row"> <div class="col-sm-8"> <div class="blog-post"> <div class="panel panel-post"> <div class="action-post"> <div class="btn-group" role="group" aria-label="..."> <a href="<?php echo e(route('posts_edit', ['id' => $post->id])); ?>" type="button" class="btn btn-default">Edit</a> <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete" data-id="<?php echo e($post->id); ?>">Delete</a> </div> </div> <div> <img src="<?php echo e(asset('uploaded/media/'.$post->image)); ?>" width="100%"> </div> <div class="wrapper-lg"> <h2 class="m-t-none"><a href="<?php echo e(route('posts_detail', ['slug' => $post->slug ])); ?>"><?php echo e($post->title); ?></a></h2> <hr> <?php echo $post->content ?>
 <div class="line line-lg b-b b-light"></div> <div class="text-muted"> <i class="glyphicon glyphicon-user"></i> &nbsp;by <a href="#" class="m-r-sm"><?php echo e($post->fullname); ?></a> <i class="glyphicon glyphicon-time"></i> &nbsp;<?php echo e(Carbon\Carbon::parse($post->published)->format('d F Y')); ?> <?php if($post->comment == 1 ): ?> <?php $counts = DB::table('comments')->select('id_posts')->where('id_posts', $post->id)->count(); ?>
 <a class="m-l-sm post-comment-toggle"><i class="glyphicon glyphicon-comment"></i> &nbsp;<?php echo e($counts); ?> comments</a> <h4 class="m-t-lg m-b"><?php echo e($counts); ?> Comments</h4> <?php $__currentLoopData = $comment->where('id_posts', $post->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <div> <div> <a class="pull-left thumb-sm"> <img src="<?php echo e(asset('uploaded/users')); ?>/<?php echo e($c->image); ?>" class="img-circle"> </a> <div class="m-l-xxl m-b"> <div> <a href><strong><?php echo e($c->fullname); ?></strong></a> <span class="text-muted text-xs block m-t-xs"> <?php echo e(Carbon\Carbon::parse($c->created_at)->diffForHumans()); ?> </span> </div> <div class="m-t-sm"><?php echo e($c->comment); ?></div> </div> </div> <?php $__currentLoopData = $parents->where('id_parent', $c->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <div class="m-l-xxl"> <a class="pull-left thumb-sm"> <img src="<?php echo e(asset('uploaded/users/')); ?>/<?php echo e($parent->image); ?>" class="img-circle"> </a> <div class="m-l-xxl m-b"> <div> <a href><strong><?php echo e($parent->fullname); ?></strong></a> <span class="text-muted text-xs block m-t-xs"> <?php echo e(Carbon\Carbon::parse($parent->created_at)->diffForHumans()); ?> </span> </div> <div class="m-t-sm"><?php echo e($parent->comment); ?></div> </div> </div> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <div class="m-l-xxl"> <form action="<?php echo e(route('comment_store')); ?>" method="post"> <?php echo e(csrf_field()); ?> <input type="hidden" name="id_user" value="<?php echo e(Auth::user()->id); ?>"> <input type="hidden" name="id_parent" value="<?php echo e($c->id); ?>"> <input type="hidden" name="id_posts" value="<?php echo e($post->id); ?>"> <a class="pull-left thumb-sm"> <img src="<?php echo e(asset('uploaded/users').'/thumb-'.Auth::user()->image); ?>" class="img-circle"> </a> <div class="m-l-xxl m-b"> <textarea class="form-control" name="comment" rows="3" placeholder="Type your comment"></textarea> </div> <div class="m-l-xxl m-b"> <button type="submit" class="btn btn-default"><i class="fa fa-mail-reply"></i>&nbsp; Reply</button> </div> </form> </div> </div> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <h4 class="m-t-lg m-b">Leave a comment</h4> <form action="<?php echo e(route('comment_store')); ?>" method="post"> <?php echo e(csrf_field()); ?> <input type="hidden" name="id_user" value="<?php echo e(Auth::user()->id); ?>"> <input type="hidden" name="id_parent" value="0"> <input type="hidden" name="id_posts" value="<?php echo e($post->id); ?>"> <div class="form-group"> <textarea class="form-control" rows="5" name="comment" placeholder="Type your comment"></textarea> </div> <div class="form-group"> <button type="submit" class="btn btn-default">Submit comment</button> </div> </form> <?php endif; ?> </div> </div> </div> </div> </div> <div class="col-sm-4"> <?php if($drafts->count() > 0): ?> <h5 class="font-bold">You have <?php echo e($drafts->count()); ?></span> draft</h5> <ul class="list-group"> <?php $__currentLoopData = $drafts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $draft): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li class="list-group-item"> <a href="<?php echo e(route('posts_edit', ['id' => $draft->id ])); ?>"> <?php echo e($draft->title); ?> </a> </li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </ul> <?php endif; ?> <h5 class="font-bold">Categories</h5> <ul class="list-group"> <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $valuePosts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $valueCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php if($valuePosts->category == $valueCategory->id): ?> <li class="list-group-item"> <a href="<?php echo e(route('posts_view_category', ['category' => $valueCategory->id ])); ?>"> <span class="badge bg-default pull-right"><?php echo e($valuePosts->count); ?></span> <?php echo e($valueCategory->name); ?> </a> </li> <?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?> <small>No category found</small> <?php endif; ?> </ul> <h5 class="font-bold">Recent Posts</h5> <div> <?php $__empty_1 = true; $__currentLoopData = $recent_posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> <div> <a class="pull-left thumb thumb-wrapper m-r"> <div class="img-recent" style="background-image:url('<?php echo e(asset('uploaded/media/'.$rp->image)); ?>')"></div> </a> <div class="clear"> <a href="<?php echo e(route('posts_detail', ['slug' => $rp->slug ])); ?>" class="font-semibold text-ellipsis"><?php echo e($rp->title); ?></a> <div class="text-xs block m-t-xs"><?php echo e(Carbon\Carbon::parse($rp->published)->diffForHumans()); ?></div> </div> </div> <div class="line"></div> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?> <small>No recent posts found</small> <?php endif; ?> </div> </div> </div> </div> <?php $__env->stopSection(); ?> <?php $__env->startSection('modal'); ?> <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog modal-sm" role="document"> <form action="<?php echo e(route('posts_delete')); ?>" method="post"> <?php echo e(csrf_field()); ?> <input type="hidden" name="id"> <div class="modal-content"> <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> <h4 class="modal-title" id="myModalLabel">Delete Post</h4> </div> <div class="modal-body"> <input type="hidden" name="id"> Are you sure you want to delete this post? </div> <div class="modal-footer"> <button type="button" class="btn btn-default" data-dismiss="modal">No</button> <button type="submit" class="btn btn-danger">Yes</button> </div> </div> </form> </div> </div> <?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
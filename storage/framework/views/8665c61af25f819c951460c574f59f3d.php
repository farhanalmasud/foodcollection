

<?php $__empty_1 = true; $__currentLoopData = $conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php
        $user = $conv->sender_type == 'admin' ? $conv->receiver : $conv->sender;
        $lastMessage = $conv->last_message;
    ?>

    <?php if($user): ?>
        <?php
            // Only count as unread when the newest message came from the other
            // side: unread_message_count is also bumped for admin's own replies.
            $unread = $lastMessage?->sender_id == $user->id ? (int) $conv->unread_message_count : 0;
            $isReply = $lastMessage && $lastMessage->sender_id != $user->id;
            $preview = trim((string) ($lastMessage?->message ?? ''));
            $hasAttachment = ! empty($lastMessage?->file_full_url);
            $isDeliveryMan = (bool) $user->deliveryman_id;

            $sentAt = $lastMessage?->created_at ?? $conv->last_message_time;
            $sentAt = $sentAt ? \Carbon\Carbon::parse($sentAt) : null;
            $stamp = match (true) {
                ! $sentAt => '',
                $sentAt->isToday() => \App\CentralLogics\Helpers::time_format($sentAt),
                $sentAt->isYesterday() => translate('messages.yesterday'),
                $sentAt->isCurrentYear() => $sentAt->translatedFormat('d M'),
                default => $sentAt->translatedFormat('d M Y'),
            };
        ?>

        <div class="msg-item customer-list view-conv <?php echo e($unread ? 'is-unread' : ''); ?>" id="customer-<?php echo e($user->id); ?>"
            role="button" tabindex="0" data-url="<?php echo e(route('admin.message.view', ['conversation_id' => $conv->id, 'user_id' => $user->id])); ?>"
            data-conv-id="<?php echo e($conv->id); ?>" data-sender-id="<?php echo e($user->id); ?>"
            aria-label="<?php echo e(trim($user->f_name . ' ' . $user->l_name)); ?>">

            <?php echo $__env->make('partials._user-avatar', [
                'imageUrl' => $user['image_full_url'],
                'proStatus' => $user['pro_status'] ?? false,
                'size' => 42,
                'wrapperClass' => 'msg-item__avatar',
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div class="msg-item__body">
                <div class="msg-item__row">
                    <h6 class="msg-item__name"><?php echo e(trim($user->f_name . ' ' . $user->l_name) ?: translate('No data found')); ?></h6>
                    <span class="msg-item__time"><?php echo e($stamp); ?></span>
                </div>

                <div class="msg-item__row">
                    <p class="msg-item__preview">
                        <?php if($isReply): ?>
                            <?php echo e(translate('messages.You')); ?>:
                        <?php endif; ?>

                        <?php if($preview !== ''): ?>
                            <?php echo e(Str::limit($preview, 46, '...')); ?>

                        <?php elseif($hasAttachment): ?>
                            <i class="tio-image"></i><?php echo e(translate('Attachment')); ?>

                        <?php else: ?>
                            <?php echo e(translate('messages.No messages yet')); ?>

                        <?php endif; ?>
                    </p>

                    <?php if($unread): ?>
                        <span class="msg-item__badge"><?php echo e($unread > 99 ? '99+' : $unread); ?></span>
                    <?php endif; ?>
                </div>

                <div class="msg-item__meta">
                    <span class="msg-chip <?php echo e($isDeliveryMan ? 'msg-chip--deliveryman' : 'msg-chip--customer'); ?>">
                        <i class="<?php echo e($isDeliveryMan ? 'tio-bike' : 'tio-user-outlined'); ?>"></i>
                        <?php echo e($isDeliveryMan ? translate('Deliveryman') : translate('messages.Customer')); ?>

                    </span>
                    <?php if($user->phone): ?>
                        <span class="msg-item__phone" dir="ltr"><?php echo e($user->phone); ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="msg-item customer-list" aria-disabled="true">
            <div class="msg-item__avatar">
                <img class="rounded-circle" width="42" height="42"
                    src="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>" alt="">
            </div>
            <div class="msg-item__body">
                <div class="msg-item__row">
                    <h6 class="msg-item__name"><?php echo e(translate('No data found')); ?></h6>
                </div>
                <p class="msg-item__preview"><?php echo e(translate('messages.This account is no longer available')); ?></p>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="msg-empty">
        <i class="tio-comment-outlined"></i>
        <h6><?php echo e(translate('No conversation found')); ?></h6>
        <p><?php echo e(translate('messages.Conversations started by customers and delivery men will show up here')); ?></p>
    </div>
<?php endif; ?>
<?php /**PATH /home/foodcol2/portal.foodcollections.com/resources/views/admin-views/messages/data.blade.php ENDPATH**/ ?>
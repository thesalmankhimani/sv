<?php if (isset($chats[0])): ?>
    <?php foreach ($chats as $chat): ?>
        <?php $div_float = $_SESSION['auth']['id'] == $chat['user_id'] ? 'right' : 'left'; ?>
        <?php $time_float = $div_float == 'left' ? 'right' : 'left'; ?>
        <div id="chat_data" class="text-<?php echo $div_float; ?>">
            <span><?php echo $_SESSION['auth']['id'] == $chat['user_id'] ? '' : $chat['first_name']; ?> </span>
            <span class="<?php echo $_SESSION['auth']['id'] == $chat['user_id'] ? 'text-success' : 'text-primary'; ?>"><?php echo $chat['message']; ?></span>
            <small style="float:<?php echo $time_float; ?>;"><?php echo date('H:i', strtotime($chat['created_at'])); ?></small>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div id="be_first" class="alert alert-info" role="alert">Be first to initiate chat...</div>
<?php endif; ?>

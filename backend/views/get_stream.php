<?php
if ($stream): ?>
    <div class="col-md-12 mx-auto">
        <div class="alert alert-info" role="alert"><?php echo $stream['title']; ?></div>
    </div>


    <div class="row p-3">
        <!-- streaming -->
        <div class="col-md-6">
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item"
                        src="https://www.youtube.com/embed/<?php echo $stream['video_id']; ?>"></iframe>
            </div>
        </div>

        <!-- chat window -->
        <div class="col-md-6">
            <div class="w-100 pb-4 alert alert-warning">
                <div class="col-md-6 float-left">Messages : <span id="message_count">0</span></div>
                <div class="col-md-6 float-left">Users : <span id="user_count">0</span></div>
            </div>
            <div class="row">
                <div class="embed-responsive embed-responsive-16by9">
                    <div class="col-md-12 chatbox embed-responsive-item" id="container">
                        <div id="chat_box"></div>
                        <form name="chat_form">
                            <textarea name="message" placeholder="Enter Message"></textarea> <input type="submit"
                                                                                                    name="submit"
                                                                                                    value="Send!"/>
                        </form>

                    </div>

                </div>
            </div>
        </div>

    </div>
    <script type="text/javascript">
        $(function () {
            // for chat page
            $('form[name=chat_form]').submit(function (e) {
                e.preventDefault();
                post_chat('<?php echo $stream['video_id']; ?>');
            });

            // load previous chat
            load_chat('<?php echo $stream['video_id']; ?>');

            // load chat every 2 second
            setInterval(function () {
                load_chat('<?php echo $stream['video_id']; ?>');
                $("div#chat_box").animate({scrollTop: $('div#chat_box').height()}, 1000);
            }, 2000);
        });

    </script>

<?php else: ?>
    <div class="col-md-6">
        <div class="alert alert-danger" role="alert">
            Could not found selected stream, please try again later...
        </div>
    </div>

<?php endif; ?>

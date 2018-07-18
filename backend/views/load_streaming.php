<h2 class="welcome">Welcome <?php echo $_SESSION['auth']['first_name']; ?> !!</h2>

<?php
if (isset($streaming_json->items[0])): ?>
    <div class="col-md-6 mx-auto">
        <div class="alert alert-info" role="alert">
            Choose from below streams :
        </div>
    </div>

    <div class="col-md-9 mx-auto">
        <div class="card-columns">
            <?php foreach ($streaming_json->items as $item): ?>
                <?php
                // thumbnail
                $thumb_url = $item->snippet->thumbnails->high ?
                    $item->snippet->thumbnails->high->url :
                    $item->snippet->thumbnails->default->url;

                // save into db for next page
                $save_data = [
                    'title' => $item->snippet->title,
                    'description' => $item->snippet->description,
                    'channel_title' => $item->snippet->channelTitle,
                    'channel_id' => $item->snippet->channelId,
                    'video_id' => $item->id->videoId,
                    'thumbnails' => json_encode($item->snippet->thumbnails),
                    'published_at' => date('Y-m-d H:i:s', strtotime($item->snippet->publishedAt)),
                    'created_at' => date('Y-m-d H:i:s')
                ];

                // insert
                //$db_class->insert('streams', $save_data);
                $sql = "INSERT INTO streams SET
                `title` = '".$db_con->escape_string($save_data['title'])."',
                `description` = '".$db_con->escape_string($save_data['description'])."',
                `channel_title` = '".$db_con->escape_string($save_data['channel_title'])."',
                `channel_id` = '$save_data[channel_id]',
                `video_id` = '$save_data[video_id]',
                `thumbnails` = '$save_data[thumbnails]',
                `published_at` = '$save_data[published_at]',
                `created_at` = '$save_data[created_at]'
                ";
                try {
                    $db_con->query($sql);
                } catch (Exception $e) {
                    // nothing
                }
                ?>
                <div class="card">
                    <a href="#<?php echo $item->id->videoId; ?>">
                        <img class="card-img-top" src="<?php echo $thumb_url; ?>" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $item->snippet->title; ?></h5>
                            <p class="card-text"><?php echo $item->snippet->description; ?></p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Date : <?php echo $save_data['published_at']; ?></small>
                        </div>
                    </a>
                </div>

            <?php endforeach; ?>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            // bind each class link
            $('div.card > a').click(function(e) {
                var video_id = $(this).attr('href').replace('#','');
                get_stream(video_id);
            });
        });
    </script>

<?php else: ?>
    <div class="col-md-6">
        <div class="alert alert-danger" role="alert">
            Could not found streaming, please try again later...
        </div>
    </div>

<?php endif; ?>
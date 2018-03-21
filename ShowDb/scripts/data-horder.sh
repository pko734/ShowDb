#!/bin/sh

s3fs images.db.nov.blue /mnt/s3 -o use_path_request_style -o dbglevel=info -o url=https://s3-us-east-2.amazonaws.com -o curldbg
cd /mnt/s3/videos/archive
youtube-dl --download-archive /mnt/s3/videos/archive/downloaded.txt -i -o "%(uploader)s/%(upload_date)s - %(title)s - (%(duration)ss) [%(resolution)s].%(ext)s" -f bestvideo[ext=mp4]+bestaudio --batch-file=/mnt/s3/videos/archive/channel_list.txt
umount -l /mnt/s3


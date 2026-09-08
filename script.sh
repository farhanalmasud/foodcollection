#!/bin/bash
(crontab -l | grep -v "/usr/local/bin/ea-php99 /home/foodcol2/portal.foodcollections.com/artisan dm:disbursement") | crontab -

(crontab -l | grep -v "/usr/local/bin/ea-php99 /home/foodcol2/portal.foodcollections.com/artisan store:disbursement") | crontab -


<?php
date_default_timezone_set("Europe/Berlin");
$time = date("Y-m-d_H-i-s");
if (is_dir("/release/")) {
    echo "Removing directory ./release/";
    system("rmdir ./release/");
}

echo "Creating directory ./release/\n";
system("mkdir ./release/");

echo "Unzipping $argv[1]\n";
system("unzip $argv[1] -d ./release/");

if (is_dir("./htdocs/")){
    echo "Renaming ./htdocs/ to ./htdocs_$time\n";
    system("mv ./htdocs/ ./htdocs_$time");
}

echo "Renaming ./release/ to ./htdocs/\n";
system("mv ./release/ ./htdocs/");

echo "Removing zipfile $argv[1]\n";
system("rm $argv[1] -rf");

if (!is_dir("./htdocs/tmp")) {
    echo "Creating /tmp directory";
    system("mkdir ./htdocs/tmp");
    // TODO BEFORE GOING LIVE: ADD FOLLOWING IMAGES AGAIN AND FIND BACKUP SOLUTION FOR IMAGES IN DEPLOYMENT SCRIPT
    //
    // Allgäu :147bbc12-b22e-4cf8-b0f5-6f95723b5fbb :> f007a8f6-8698-4455-9a0a-7959a9aad68a:> img/cache/i_180910/dfd01c0c-b4e8-45b1-b321-1099473afef5.png
    // Leutkirch: 576911ea-3581-4242-8e87-070560bb9b3a :> a536b6bc-1f3d-45f1-b357-1b5bfe9e0e70 :> img/cache/i_180911/1229d68f-3e09-4549-ad9f-0754c9c46d0c.png
}

if (!is_dir("./htdocs/tmp/logs")) {
    echo "Creating /logs directory";
    system("mkdir ./htdocs/tmp/logs");
}

if (!is_dir("./htdocs/tmp/cache")) {
    echo "Creating /cache directory";
    system("mkdir ./htdocs/tmp/cache");
}

echo "Updating directory permissions to 775\n";
system("chmod -R 775 ./htdocs/tmp/");

echo "Updating permissions";
system("chmod 775 ./htdocs/vendor/bin/phinx && chmod -R 775 ./htdocs/vendor/robmorgan/");

echo "Migrating database";
system("cd htdocs/config/ && ../vendor/bin/phinx migrate");
system("cd ..");

echo "Deleting old Backups ...";
system("php clean-up.php 31536000");

echo "\n";
echo "--------------------------------------------------------\n";
echo "Server deployment done\n";
echo "--------------------------------------------------------\n";
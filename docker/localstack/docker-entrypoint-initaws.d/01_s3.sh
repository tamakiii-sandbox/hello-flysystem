#!/usr/bin/env bash -xe

awslocal s3api create-bucket --bucket example.com
awslocal s3 cp /tmp/init/profile.png s3://example.com/profile/profile.png

<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Yaml\Yaml;
use Aws;
use League\Flysystem;

class UploadImageCommand extends Command
{
    protected static $defaultName = 'app:upload-image';

	protected function configure()
    {
        $this
            ->setDescription('Uploads file command')
			->addArgument('file', InputArgument::REQUIRED, 'File to upload')
			->addArgument('mime-type', InputArgument::REQUIRED, 'Mime-Type of upload file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

		$filepath = $input->getArgument('file');
		$mimeType = $input->getArgument('mime-type');

        $client = new Aws\S3\S3Client([
			'endpoint' => 'http://localhost:4566',
			'region' => 'ap-northeast-1',
			'version' => 'latest',
			'profile' => 'localstack',
			'use_path_style_endpoint' => true,
		]);

		$file = fopen($filepath, 'r');

		$adapter = new Flysystem\AwsS3V3\AwsS3V3Adapter($client, 'example.com');
		$filesystem = new Flysystem\Filesystem($adapter);

		$result = $filesystem->writeStream('profile/profile.png', $file);

		// $result = $client->putObject([
		// 	'Bucket' => 'example.com',
		// 	'Key' => 'profile/profile.png',
		// 	'Body' => $file,
		// 	'ContentType' => $mimeType,
		// ]);

		$io->writeln(json_encode($result));

        return Command::SUCCESS;
	}
}


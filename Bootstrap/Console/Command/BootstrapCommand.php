<?php
declare(strict_types=1);

namespace Kammersell\Bootstrap\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BootstrapCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('dev:bootstrap:module')
            ->setDescription('Create minimal module skeleton from templates')
            ->addArgument('vendor', InputArgument::REQUIRED)
            ->addArgument('namespace', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $vendor = preg_replace('/[^A-Za-z0-9]/', '', $input->getArgument('vendor'));
        $namespace = preg_replace('/[^A-Za-z0-9]/', '', $input->getArgument('namespace'));
        $modulePath = BP . "/app/code/$vendor/$namespace";
        $templatePath = __DIR__ . '/../../Templates';

        mkdir("$modulePath/etc", 0775, true);

        $this->render("$templatePath/registration.php.tpl", "$modulePath/registration.php", $vendor, $namespace);
        $this->render("$templatePath/module.xml.tpl", "$modulePath/etc/module.xml", $vendor, $namespace);
        $this->render("$templatePath/composer.json.tpl", "$modulePath/composer.json", $vendor, $namespace);

        return Command::SUCCESS;
    }

    private function render(string $templateFile, string $targetFile, string $vendor, string $namespace): void
    {
        $content = file_get_contents($templateFile);
        $content = str_replace(['{{VENDOR}}', '{{NAMESPACE}}','{{LOWERCASE_NAMESPACE}}'], [$vendor, $namespace, strtolower($namespace)], $content);
        file_put_contents($targetFile, $content);
    }
}

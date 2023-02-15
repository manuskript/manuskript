<?php

namespace Manuskript\Console;

class PolicyCommand extends Command
{
    protected $signature = 'manuskript:policy {name?}';

    protected $description = 'Create a Manuskript policy';

    public function handle(): void
    {
        $name = $this->argument('name') ?? $this->ask('What is the name of the policy?');

        $rootNamespace = $this->getApplicationNamespace();

        if (!is_dir(app_path('Manuskript/Policies'))) {
            mkdir(app_path('Manuskript/Policies'), 0777, true);
        }

        file_put_contents(
            app_path('Manuskript/Policies/' . $name . '.php'),
            str_replace(
                ['__NAMESPACE__', '__NAME__'],
                [$rootNamespace, $name],
                file_get_contents($this->stubPath('policy.stub'))
            )
        );

        $this->info('Policy successfully created.');
    }
}

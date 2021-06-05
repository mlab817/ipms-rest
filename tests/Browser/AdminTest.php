<?php

namespace Tests\Browser;

use App\Models\Project;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_it_shows_manage_projects_page()
    {
        $this->browse(function (Browser $browser) {
            $browser
                    ->loginAs(1)
                    ->visit('/admin/projects')
                    ->assertSee('Manage Projects')
                    ->screenshot('admin/manage-projects');
        });
    }

    public function test_it_shows_manage_users_page()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs(1)
                ->visit('/admin/users')
                ->assertSee('Manage Users')
                ->screenshot('admin/manage-users')
                ->press('Create')
                ->assertSee('Add User')
                ->screenshot('admin/manage-users-add')
                ->clickLink('Back to List')
                ->pause(1000)
                ->clickLink('Edit')
                ->assertSee('Edit User')
                ->screenshot('admin/manage-users-edit');
        });
    }

    public function test_it_shows_manage_roles_page()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs(1)
                ->visit('/admin/roles')
                ->assertSee('Manage Roles')
                ->screenshot('admin/manage-roles')
                ->press('Create')
                ->assertSee('Add Role')
                ->screenshot('admin/manage-roles-add')
                ->clickLink('Back to List')
                ->pause(1000)
                ->clickLink('Edit')
                ->assertSee('Edit Role')
                ->screenshot('admin/manage-roles-edit');
        });
    }

    public function test_it_shows_manage_permissions_page()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs(1)
                ->visit('/admin/permissions')
                ->assertSee('Manage Permissions')
                ->screenshot('admin/manage-permissions')
                ->pause(1000)
                ->clickLink('Edit')
                ->assertSee('Edit Permission')
                ->screenshot('admin/manage-permissions-edit');
        });
    }

    public function test_it_shows_manage_libraries_page()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs(1)
                ->visit('/admin')
                ->assertSee('Manage Libraries')
                ->screenshot('admin/manage-libraries');
        });
    }

    public function test_it_shows_audit_logs_page()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs(1)
                ->visit('/admin/audit_logs')
                ->assertSee('Audit Logs')
                ->screenshot('admin/audit-logs')
                ->pause(1000)
                ->clickLink('View')
                ->assertSee('View Audit Log')
                ->screenshot('admin/audit-logs-view');
        });
    }
}

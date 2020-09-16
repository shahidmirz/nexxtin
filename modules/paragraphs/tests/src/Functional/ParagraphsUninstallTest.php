<?php

namespace Drupal\Tests\paragraphs\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Tests that Paragraphs module can be uninstalled.
 *
 * @group paragraphs
 */
class ParagraphsUninstallTest extends BrowserTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = array('paragraphs_demo');

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    $admin_user = $this->drupalCreateUser(array(
      'administer paragraphs types',
      'administer modules',
    ));
    $this->drupalLogin($admin_user);
  }

  /**
   * Tests that Paragraphs module can be uninstalled.
   */
  public function testUninstall() {

    // Uninstall the module paragraphs_demo.
    $this->drupalPostForm('admin/modules/uninstall', ['uninstall[paragraphs_demo]' => TRUE], 'Uninstall');
    $this->drupalPostForm(NULL, [], 'Uninstall');

    // Delete library data.
    $this->clickLink('Remove Paragraphs library items');
    $this->drupalPostForm(NULL, [], 'Delete all Paragraphs library items');

    // Uninstall the library module.
    $this->drupalPostForm('admin/modules/uninstall', ['uninstall[paragraphs_library]' => TRUE], 'Uninstall');
    $this->drupalPostForm(NULL, [], 'Uninstall');

    // Delete paragraphs data.
    $this->clickLink('Remove Paragraphs');
    $this->drupalPostForm(NULL, [], 'Delete all Paragraphs');

    // Uninstall the module paragraphs.
    $this->drupalPostForm('admin/modules/uninstall', ['uninstall[paragraphs]' => TRUE], 'Uninstall');
    $this->drupalPostForm(NULL, [], 'Uninstall');
    $this->assertSession()->pageTextContains('The selected modules have been uninstalled.');
    $this->assertSession()->pageTextNotContains('Paragraphs demo');
    $this->assertSession()->pageTextNotContains('Paragraphs library');
    $this->assertSession()->pageTextNotContains('Paragraphs');
  }

}

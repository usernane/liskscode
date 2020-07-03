<?php
namespace webfiori\tests\entity;

use PHPUnit\Framework\TestCase;
use webfiori\conf\SiteConfig;
use webfiori\entity\Theme;
use webfiori\entity\ThemeLoader;
/**
 * Description of ThemeTest
 *
 * @author Ibrahim
 */
class ThemeTest extends TestCase {
    public function testAvailableThemes00() {
        $themes = ThemeLoader::getAvailableThemes();
        $this->assertEquals(7,count($themes));
    }
    /**
     * @test
     */
    public function testToJson00() {
        $theme = ThemeLoader::usingTheme();
        $this->assertEquals('{"themesPath":"'.\jsonx\JsonX::escapeJSONSpecialChars(THEMES_PATH).'", "name":"WebFiori Theme", "url":"https:\/\/ibrahim-2017.blogspot.com\/", "license":"MIT License", "licenseUrl":"https:\/\/opensource.org\/licenses\/MIT", "version":"1.0.1", "author":"Ibrahim Ali", "authorUrl":"", "imagesDirName":"images", "themeDirName":"webfiori", "cssDirName":"css", "jsDirName":"js", "components":["LangExt.php"]}',$theme->toJSON().'');
    }
    /**
     * @test
     */
    public function testUseTheme00() {
        $themeName = 'WebFiori Theme';
        ThemeLoader::resetLoaded();
        //$this->assertFalse(Theme::isThemeLoaded($themeName));
        $theme = ThemeLoader::usingTheme($themeName);
        $this->assertTrue($theme instanceof Theme);
        $this->assertTrue(ThemeLoader::isThemeLoaded($themeName));
        $this->assertEquals('1.0.1',$theme->getVersion());
        $this->assertEquals('The main theme for WebFiori Framework.',$theme->getDescription());
        $this->assertEquals('Ibrahim Ali',$theme->getAuthor());
        $this->assertEquals('https://opensource.org/licenses/MIT',$theme->getLicenseUrl());
        $this->assertEquals('MIT License',$theme->getLicenseName());
        $this->assertEquals(1,count(ThemeLoader::getLoadedThemes()));
    }
    /**
     * @test
     */
    public function testUseTheme01() {
        $theme = ThemeLoader::usingTheme();
        $this->assertTrue($theme instanceof Theme);
        $this->assertEquals('WebFiori Theme',$theme->getName());
        $this->assertEquals(SiteConfig::getBaseURL(),$theme->getBaseURL());
        $theme->setBaseURL('https://example.com/x');
        $this->assertEquals('https://example.com/x',$theme->getBaseURL());
    }
    /**
     * @test
     */
    public function testUseTheme02() {
        $themeName = 'Not Exist';
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('No such theme: \''.$themeName.'\'.');
        ThemeLoader::usingTheme('Not Exist');
    }
}

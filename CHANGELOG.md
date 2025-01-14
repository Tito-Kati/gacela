# Changelog

### 0.13.0
#### 2022-03-01

- Added allow defining a config reader as class-string too.
- Moved the "config readers" next to their config item itself.
  - Performance improvement specially when using different config readers in the same project.
- Added OverrideResolvableTypes feature
  - Allow overriding Gacela resolvable types (Factory, Config, DependencyProvider).
- Removed deprecated methods `getApplicationRootDir()` & `setApplicationRootDir()` from Config.
  - Use `getAppRootDir()` & `setAppRootDir()` instead.
- Deprecated and removed `CustomService` feature. Use `MappingInterfaces` feature instead.
  - Why? Too much magic.

### 0.12.0
#### 2022-02-13

- Added `getAppRootDir()` to AbstractConfig.
- Added `APP_ENV` environment key, to define different config files on different environments.
- Added `'config-readers'` key in the globalServices and `gacela.php`.
- Added `'custom-services-location'` key in the globalServices and `gacela.php`.
  - Define namespaces (relative to a module) where Gacela should check for custom services that will be auto-resolved.
- Deprecated `getApplicationRootDir()` from Config. Use `getAppRootDir()` instead.
- Removed `EnvConfigReader` from `gacela-project/gacela`.
  - If you want to read `.env` values, you should require `gacela-project/gacela-env-config-reader`.

### 0.11.0
#### 2022-01-18

- Deleted deprecated array config in `gacela.php`.
- Allow `null` as default config value.
- The globalServices are passed into `mappingInterfaces()` and not as constructor argument.

### 0.10.0
#### 2021-10-04

- Allow setup custom config from `Gacela::bootstrap()` directly.

### 0.9.0
##### 2021-08-27

- Allow return JsonSerializable objects in PHP config files.

### 0.8.0
##### 2021-08-16

- Updated `gacela.php` config file:
  - returning a simple array has been deprecated,
  - an anonymous function that creates an anonymous class that extends from AbstractConfigGacela should be used.
- Remove deprecated `gacela.json` config file.

### 0.7.0
##### 2021-08-07

- Improve the flexibility from the ConfigReaders.
- Deprecated `gacela.json` config file, in favor of `gacela.php`.
- Added 'mapping-interfaces' key to `gacela.php`.
- Added autowiring for Factory dependencies.

### 0.6.0
##### 2021-07-27

- Added `AbstractClassResolver::overrideExistingResolvedClass()`.
- Locator uses `AbstractClassResolver::getGlobalInstance()` before creating a new instance.
- Unify the cacheKey using `GlobalKey`.

### 0.5.0
##### 2021-07-19

- `Config::setConfigReaders()` create a new config instance singleton.
- Added `AbstractClassResolver::addAnonymousGlobal()` you can now use anonymous classes.
- Added matrix for the GitHub CI for diff PHP versions (7.4,8.0), and diff OS (mac,linux,windows).

### 0.4.0
##### 2021-07-10

- Allow multiple (and different) config files defined in `gacela.json`.
- Make extensible the Config Readers.

### 0.3.0
##### 2021-07-04

- Allow using config php and env files defined in `gacela.json`.
- Use long name by default in the generator code commands. Optional short names.

### 0.2.0
##### 2021-04-27

- Added CodeGenerator.
- Refactoring Config reading all php files from config directory.

### 0.1.0
##### 2021-04-02

- Added Facade, Factory, Config and DependencyProvider basic functionality.
- Provide documentation for each of these concepts with examples.

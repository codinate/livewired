# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]

## 0.6.0 - 2020-04-17

### Changed

- Add `laravel/passport` components
- Add `laravel/sanctum` components

## 0.5.6 - 2020-03-27

### Changed

- Removed redirects after switching teams to let `before` and `after` handle them if needed.

## 0.5.5 - 2020-03-24

### Removed

- Removed UUID generation from `InviteTeamMember`

## 0.5.4 - 2020-03-21

### Changed

- Replaced `laravel/airlock` with `laravel/sanctum`

## 0.5.3 - 2020-03-17

### Fixed

- Expect invitation id for acceptance/rejection

## 0.5.2 - 2020-03-04

### Added

- Added `PendingInvitations` component

## 0.5.1 - 2020-03-03

### Changed

- Wrong `kodekeep/laravel-addresses` service provider

## 0.5.0 - 2020-03-03

### Added

- Livewire 1.0 Support

## 0.4.0 - 2020-03-03

### Added

- Airlock 1.0 Support

## 0.3.3 - 2020-03-01

### Added

- Added ability to update slug in `UpdateTeamName`

## 0.3.2 - 2020-03-01

### Fixed

- `hasMethodOrMacro` conditional

## 0.3.1 - 2020-03-01

### Fixed

- Added missing property getters
- Add team owner after creating a team

## 0.3.0 - 2020-03-01

### Added

- Test Suite

### Changed

- Moved all components into the `KodeKeep\Livewired\Components` namespace
- Require certain components to set their data via event listeners. **This changed was made due to how some components are used in the context of UI/UX to avoid page reloads which means an event listener had to be used because nested Livewire components are not reactive.**

## 0.2.1 - 2020-02-29

### Fixed

- Store permissions when creation an invitation

## 0.2.0 - 2020-02-29

### Added

- Added `ExportTeamData` component
- Added `ExportProfileData` component

### Fixed

- Various wrong type hints

## 0.1.9 - 2020-02-29

### Fixed

- Use configured models from `kodekeep/laravel-teams`

## 0.1.8 - 2020-02-29

### Fixed

- Added missing views

## 0.1.7 - 2020-02-29

### Added

- Added `UpdateTeamPhoto` component
- Added `UpdateProfilePhoto` component

## 0.1.6 - 2020-02-29

### Added

- Added notification method components

## 0.1.5 - 2020-02-29

### Changed

- Store the newly created team in `CreateTeam`

## 0.1.4 - 2020-02-29

### Changed

- Allow before/after methods to be macros

## 0.1.3 - 2020-02-29

### Added

- Added `UpdateProfileInformation` component

## 0.1.2 - 2020-02-29

### Fixed

- Handle view name creation with default livewire namespace

## 0.1.1 - 2020-02-29

### Fixed

- Register `livewired` namespace for views

## 0.1.0 - 2020-02-29

- initial release

[Unreleased]: https://github.com/kodekeep/livewired/compare/master...develop

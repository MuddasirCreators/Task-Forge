# TaskForge Changes

## Resubmission Corrections

### Authorization
- Added ClientPolicy
- Added ProjectPolicy
- Added TaskPolicy
- Added TimeLogPolicy

### Architecture
- Moved controller business rules into Actions

### Queue System
- Added overdue task Job
- Added email notification queue

### Events
- Added ProjectArchived event
- Added audit listener

### Database
- Fixed project membership seeder
- Updated time logs count to exactly 100

### Testing
- Added queue dispatch tests
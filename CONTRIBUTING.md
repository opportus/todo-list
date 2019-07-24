# Contributing

First off, thank you for contributing to the project.

Following these guidelines helps to communicate that you respect the time of the team mates managing and developing the project. In return, they should reciprocate that respect.

## Workflow

The project is centered around an open approach to management and workflow. To this end, we strongly encourage that all proposals are made through the project repository so that every team member can express themselves. Contributions are managed through the following stages:

1.	Contributor expresses a requirement or an issue and proposes its solution via a single [GitHub issue](#issue).
2.	Team members review the above GitHub issue.
3.  Team leader puts the above GitHub issue in the appropriate [Kanban Board](https://github.com/opportus/todo-list/projects).
4.  Team member assigned to the above GitHub issue tags it with the appropriate *Fibonacci: [1|2|3|5|8|13|...]*.
5.  Team member assigned to the above GitHub issue opens a [GitHub pull request](#pull-request).
6.  Team members review the above GitHub pull request.
7.  Team leader merges the above GitHub pull request with the master branch.

## Issue

Before submitting a GitHub issue, make sure you're not going to duplicate any existing one by checking the current list of open and closed [issues](https://github.com/opportus/todo-list/issues).

While submitting a GitHub issue, make sure you comply with the instructions in the template. This will help team members to address it efficiently.

### Validation

Once a GitHub issue has been submitted, the entire team is entitled to discuss and assess it. For that concern, on daily basis, team members should invest a certain amount of their work time to review GitHub issues having for tag *Status: Review*. This will contribute greatly to high cohesion between team members.

Only team leader is able to accept and put a GitHub issue into an appropriate [Kanban Board](https://github.com/opportus/todo-list/projects). 

## Pull Request

GitHub pull requests must be addressed by the team member assigned to the corresponding [GitHub issue](#issue).

GitHub pull requests must address an open [GitHub issue](#issue) prealably placed in the *Todo* section of its respective [Kanban Board](https://github.com/opportus/todo-list/projects) by the team leader.

The team leader will accept the pull request only if, in addition with the above, the following has been respected:

- The branch name of the pull request follows the `issue#{id}-NameOfBranch` convention.
- The commit messages are detailed and explicit enough.
- Unit test for each new class is implemented.
- Unit test for each modified class is updated.
- Functional test and performance test for each new feature are implemented.
- Functional test and performance test for each modified feature are update.
- Travis CI build is passed.
- Merge conflicts with master branch are non-existent.

### Assessing and Integrating

Once a GitHub pull request has been submitted, the entire team is entitled to discuss and assess it. For that concern, on daily basis, team members should invest a certain amount of their work time to review pull requests having for tag *Status: Review*. This will contribute greatly to high cohesion between team members.

Only team leader is able to accept and integrate a GitHub pull request.

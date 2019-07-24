
# Contributing

First off, thank you for contributing to the project.

Following these guidelines helps to communicate that you respect the time of the team members managing and developing the project. In return, they should reciprocate that respect.

## Workflow

The project is centered around an open approach to management and workflow. To this end, we strongly encourage that all proposals are made through the project repositories so that every team member can express themselves. Contributions are managed through the following stages:

1.	Contributor expresses a requirement or an issue via an issue on GitHub
2.	Contributor proposes a solution in the same issue on GitHub
3.	Team members review the above GitHub issue (we encourage them to do that for each issue having as tag "Status: Review" on daily basis)
4.  Team leader puts the above GitHub issue in the appropriate [sprint](https://github.com/opportus/todo-list/projects)
5.  Team member assignated to the above GitHub issue tags it with the appropriate "Fibonacci: *" suite
6.  Team member assignated to the above GitHub issue [opens a GitHub pull request](#pull-requests)
7.  Team members review the above GitHub pull request (we encourage them to do that for each pull request having as tag "Status: Review" on daily basis)
8.  Team leader merges the above GitHub pull request with the master branch

## Issues

Before submitting a requirement or an issue, make sure you're not going to duplicate any existing one by checking the current list of open and closed [issues](https://github.com/opportus/todo-list/issues).

While submitting a [bug report](https://github.com/opportus/object-mapper/issues/new?template=bug_report.md) or [feature request](https://github.com/opportus/object-mapper/issues/new?template=feature_request.md), make sure you comply with the instructions in the template. This will help team members to address efficiently the issue.

## Pull Requests

Pull requests must address an open GitHub issue placed in a kanban board's TODO section.

Pull requests must be addressed by the team member assignated to the corresponding GitHub issue.

Leave detailed commit messages.

Make sure your feature or fix doesn't break the project! Implement unit test for each new class and functional test for each new feature.

Make your code passes the Travis CI build.

Before making a contribution, please ensure that you are in sync with other contributions by consulting the roadmap or the list of team members assigned to a GitHub issue. This will avoid your pull requests being refused due to merge conflict.

Before anything else, create a fork of the repository in question and create a feature branch. This branch must be named as follows: **issueXX-NameOfBranch** in which XX is the number of the GitHub issue for which you are addressing the pull request. 

Once the changes have been made on your fork, create a pull request in the master branch in the GitHub repository. 

### Good Practices

-	**commit messages**: commit messages should describe any changes made in a concise manner (approximately 50 characters);
-	**unity**: we recommend creating one pull request per new function developed;
-	**clarify**: all pull requests should be accompanied by a clear and precise description of any changes made;
-	**document**: all pull requests should be accompanied by appropriate documentation or by appropriate changes to already existing documentation;
-	**comment**: all developments should be properly commented within the source code in order to facilitate readability and understanding by other contributors.
-	**licence compatibility**: all new developments must be carried out under a licence that is compatible with the licence initially used by the tool (GPL v.3).

### Assessing and Integrating

Once a pull request has been submitted, the entire team is entitled to assess the changes, to ask questions on any changes made, to propose improvements or to request changes.

Only team leader from the master branch is able to accept and to merge your pull request. The team leader may send you requests based on the good practices set out above. 

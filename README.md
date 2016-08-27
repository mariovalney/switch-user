## Description ##

It's a plugin for developers.
The intent is create a simple interface where the logged user can switch to another user account.

This make tests and debug infos more fast (especially when you are working with different roles). 

For security:

* Only logged users can switch user accounts in website with WP_DEBUG false.
* Passwords are not revealed (of course).
* Uses the cookie authentication function 'wp_set_auth_cookie' to switch accounts.
* Implements the nonce security system (of course).

Obs: For now, the interface appears only in website, not in dashboard.

## Contribute ##

You can contribute to the source code in our [GitHub](https://github.com/mariovalney/switch-user) page.

1. Take a [fork](https://help.github.com/articles/fork-a-repo/) repository;
3. [Configure your](https://help.github.com/articles/configuring-a-remote-for-a-fork/);
2. Check [issues](https://github.com/mariovalney/switch-user/issues) and choose one that does not have anyone working;
4. [Synchronize your fork](https://help.github.com/articles/syncing-a-fork/);
2. Create a branch to work on the issue of responsibility: `git checkout -b issue-17`;
3. Commit the changes you made: `git commit -m 'Review commits you did'`;
4. Make a push to branch: `git push origin issue-17`;
5. Make a [Pull Request](https://help.github.com/articles/using-pull-requests/) :D

**Note:** If you want to contribute to something that was not recorded in the [issues](https://github.com/mariovalney/switch-user/issues) it is important to create and subscribe to prevent someone else to start working on the same thing you.

If you need help performing any of the procedures above, please access the link and [learn how to make a Pull Request](https://help.github.com/articles/creating-a-pull-request/).

## Changelog ##

#### 2.0 ####
* Code refactored (POO)
* Improved front-end
* I18n by @leobaiano

#### 1.0.#1 ###
* File architecture improved by @leobaiano

#### 1.0 ####
* First version: you can switch through all users registered.
# phpBB RegisterLog Extension

This is the repository for the development of the phpBB RegisterLog Extension.

[![Build Status](https://travis-ci.org/borisba/registerlog.svg?branch=master)](https://travis-ci.org/borisba/registerlog)

## Quick Install
You can install this on the latest copy of the develop branch ([phpBB 3.1-dev](https://github.com/phpbb/phpbb3)) by following the steps below:

1. [Download the latest release](https://github.com/BorisBerdichevski/RegisterLog).
2. Unzip the downloaded release, and change the name of the folder to `registerlog`.
3. In the `ext` directory of your phpBB board, create a new directory named `borisba` (if it does not already exist).
4. Copy the `registerlog` folder to `phpBB/ext/borisba/` (if done correctly, you'll have the main extension class at (your forum root)/ext/borisba/registerlog/ext.php).
5. Navigate in the ACP to `Customise -> Manage extensions`.
6. Look for `Register Log` under the Disabled Extensions list, and click its `Enable` link.

## Uninstall

1. Navigate in the ACP to `Customise -> Extension Management -> Extensions`.
2. Look for `New Topic` under the Enabled Extensions list, and click its `Disable` link.
3. To permanently uninstall, click `Delete Data` and then delete the `/ext/borisba/registerlog` folder.

## License
[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)

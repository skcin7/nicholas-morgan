#!/bin/bash


# https://forge.laravel.com/servers/560450/sites/1647806/application
DEPLOYMENT_TRIGGER_URL="https://forge.laravel.com/servers/560450/sites/1647806/deploy/http?token=63n7fd2enE5Zw6tBvvzf3bpYNILdlsDSvWDzxhWw"




echo "Starting Deployment...";
CURRENT_GIT_BRANCH=$(git rev-parse --symbolic-full-name --abbrev-ref HEAD);
echo "The Current Git Branch Is: \`${CURRENT_GIT_BRANCH}\`";
echo "";




DEPLOYMENT_AUTOGO_ENABLED=false
TO_RUN_ASSETS_MINIFICATION=
TO_RUN_GIT_ADD=
TO_RUN_GIT_COMMIT=
GIT_COMMIT_MESSAGE=
TO_RUN_GIT_PUSH=
TO_RUN_DEPLOY_TRIGGER_URL=


# Special flag to check for to "automatically go" (process) the deployment with pre-configured settings.
if [[ $* == *--go* ]]; then
    echo -e "Auto-Go Mode Enabled.";
    DEPLOYMENT_AUTOGO_ENABLED=true

#    TO_RUN_ASSETS_MINIFICATION="Y"
#    TO_RUN_GIT_ADD="Y"
#    TO_RUN_GIT_COMMIT="Y"
#    GIT_COMMIT_MESSAGE="Deploying to \`${CURRENT_GIT_BRANCH}\` on `date`."
#    TO_RUN_GIT_PUSH="Y"
#    TO_RUN_DEPLOY_TRIGGER_URL="Y"
fi



if [ "${DEPLOYMENT_AUTOGO_ENABLED}" = true ]; then
    echo -e "✅ Minifying JS/CSS Assets";
    TO_RUN_ASSETS_MINIFICATION="Y"
else
    read -p "Minify JS/CSS Assets? (Y/N) (Y): " TO_RUN_ASSETS_MINIFICATION
    if [ "${TO_RUN_ASSETS_MINIFICATION}" == "" ] || [ "${TO_RUN_ASSETS_MINIFICATION}" == "Y" ] || [ "${TO_RUN_ASSETS_MINIFICATION}" == "y" ]; then
    	# git add -A .
    	# echo -e "Git Command Executed!: \t \`git add -A .\` ";
    	# echo "";
    	echo -e "✅ Minifying JS/CSS Assets";
    	TO_RUN_ASSETS_MINIFICATION="Y"
    else
    	TO_RUN_ASSETS_MINIFICATION="N"
    fi
fi
echo "";




if [ "${DEPLOYMENT_AUTOGO_ENABLED}" = true ]; then
    echo -e "✅ Including Git Add";
    TO_RUN_GIT_ADD="Y"
else
    read -p "Run \`git add -A .\`? (Y/N) (Y): " TO_RUN_GIT_ADD
    if [ "${TO_RUN_GIT_ADD}" == "" ] || [ "${TO_RUN_GIT_ADD}" == "Y" ] || [ "${TO_RUN_GIT_ADD}" == "y" ]; then
    	# git add -A .
    	# echo -e "Git Command Executed!: \t \`git add -A .\` ";
    	# echo "";
    	echo -e "✅ Including Git Add";
    	TO_RUN_GIT_ADD="Y"
    else
    	TO_RUN_GIT_ADD="N"
    fi
fi
echo "";



DEFAULT_GIT_COMMIT_MESSAGE="Deploying to \`${CURRENT_GIT_BRANCH}\` on `date`."
if [ "${DEPLOYMENT_AUTOGO_ENABLED}" = true ]; then
    TO_RUN_GIT_COMMIT="Y"
    GIT_COMMIT_MESSAGE="${DEFAULT_GIT_COMMIT_MESSAGE}"

    echo -e "✅ Including Git Commit \n\t Message: ${GIT_COMMIT_MESSAGE}";
else
    read -p "Run \`git commit -m <message>\`? (Y/N) (Y): " TO_RUN_GIT_COMMIT
    if [ "${TO_RUN_GIT_COMMIT}" == "" ] || [ "${TO_RUN_GIT_COMMIT}" == "Y" ] || [ "${TO_RUN_GIT_COMMIT}" == "y" ]; then

    	read -p "Enter Git Commit Message (\"${DEFAULT_GIT_COMMIT_MESSAGE}\"): " GIT_COMMIT_MESSAGE
    	# Check if a git commit message wasn't entered, and use a default one if so.
    	if [[ -z "${GIT_COMMIT_MESSAGE}" ]]; then
    	   GIT_COMMIT_MESSAGE="${DEFAULT_GIT_COMMIT_MESSAGE}";
    	fi

    	# git commit -m "${GIT_COMMIT_MESSAGE}";
    	# echo -e "Git Command Executed!: \t \`git commit -m \"${GIT_COMMIT_MESSAGE}\"\` ";
    	# echo "";
    	echo -e "✅ Including Git Commit \n\t Message: ${GIT_COMMIT_MESSAGE}";
    	TO_RUN_GIT_COMMIT="Y"
    else
    	TO_RUN_GIT_COMMIT="N"
    fi
fi
echo "";




if [ "${DEPLOYMENT_AUTOGO_ENABLED}" = true ]; then
    echo -e "✅ Including Git Push";
    TO_RUN_GIT_PUSH="Y"
else
    read -p "Run \`git push\`? (Y/N) (Y): " TO_RUN_GIT_PUSH
    if [ "${TO_RUN_GIT_PUSH}" == "" ] || [ "${TO_RUN_GIT_PUSH}" == "Y" ] || [ "${TO_RUN_GIT_PUSH}" == "y" ]; then
    	# git push
    	# echo -e "Git Command Executed!: \t \`git push\` ";
    	# echo "";
    	echo -e "✅ Including Git Push";
    	TO_RUN_GIT_PUSH="Y"
    else
    	TO_RUN_GIT_PUSH="N"
    fi
fi
echo "";



if [ "${DEPLOYMENT_AUTOGO_ENABLED}" = true ]; then
    echo -e "✅ Run Deployment To Trigger URL";
    TO_RUN_DEPLOY_TRIGGER_URL="Y"
else
    read -p "Run deployment to trigger URL (\`${DEPLOYMENT_TRIGGER_URL}\`)? (Y/N) (Y): " TO_RUN_DEPLOY_TRIGGER_URL
    if [ "${TO_RUN_DEPLOY_TRIGGER_URL}" == "" ] || [ "${TO_RUN_DEPLOY_TRIGGER_URL}" == "Y" ] || [ "${TO_RUN_DEPLOY_TRIGGER_URL}" == "y" ]; then
    	# git push
    	# echo -e "Git Command Executed!: \t \`git push\` ";
    	# echo "";
    	echo -e "✅ Run Deployment To Trigger URL";
    	TO_RUN_DEPLOY_TRIGGER_URL="Y"
    else
    	TO_RUN_DEPLOY_TRIGGER_URL="N"
    fi
fi
echo "";






if [ "${TO_RUN_ASSETS_MINIFICATION}" == "N" ] && [ "${TO_RUN_GIT_ADD}" == "N" ] && [ "${TO_RUN_GIT_COMMIT}" == "N" ] && [ "${TO_RUN_GIT_PUSH}" == "N" ] && [ "${TO_RUN_DEPLOY_TRIGGER_URL}" == "N" ]; then
	echo "🚫 Nothing To Do!";
	echo "";
	exit 11;
fi



THE_DEPLOYMENT_IS_CONFIRMED="N"

if [ "${DEPLOYMENT_AUTOGO_ENABLED}" = false ]; then
    echo "";
    echo -e "⚠️  Confirm This Deployment (Y/N) (N): \n\t Minify JS/CSS Assets?: ${TO_RUN_ASSETS_MINIFICATION} \n\t Git Add?: ${TO_RUN_GIT_ADD} \n\t Git Commit?: ${TO_RUN_GIT_COMMIT} \n\t Git Push?: ${TO_RUN_GIT_PUSH} \n\t Deploy Trigger URL?: ${TO_RUN_DEPLOY_TRIGGER_URL}";
    read -p "" THE_DEPLOYMENT_IS_CONFIRMED
    # read -p "Looks Good? (Y/N) (N): " THE_DEPLOYMENT_IS_CONFIRMED
    if [ "${THE_DEPLOYMENT_IS_CONFIRMED}" == "Y" ] || [ "${THE_DEPLOYMENT_IS_CONFIRMED}" == "y" ]; then
    	THE_DEPLOYMENT_IS_CONFIRMED="Y"
    else
    	THE_DEPLOYMENT_IS_CONFIRMED="N"
    fi
    echo "";
else
    THE_DEPLOYMENT_IS_CONFIRMED="Y"
fi















#
# Cancel if it's not confirmed.
#
if [ "${THE_DEPLOYMENT_IS_CONFIRMED}" == "N" ]; then
    echo "🚫 Deployment Canceled!";
	echo "";
	exit 10;
fi




#Finally, actually run the deployment.
echo "Running The Deployment...";
echo "";


if [ "${TO_RUN_ASSETS_MINIFICATION}" == "Y" ]; then
    npm run prod;
    echo -e "Assets Minification Completed!";
    echo "";
fi

if [ "${TO_RUN_GIT_ADD}" == "Y" ]; then
    git add -A .
    echo -e "Git Command Completed!: \t \`git add -A .\` ";
    echo "";
fi

if [ "${TO_RUN_GIT_COMMIT}" == "Y" ]; then
    git commit -m "${GIT_COMMIT_MESSAGE}";
    echo -e "Git Command Completed!: \t \`git commit -m \"${GIT_COMMIT_MESSAGE}\"\` ";
    echo "";
fi

if [ "${TO_RUN_GIT_PUSH}" == "Y" ]; then
    git push
    echo -e "Git Command Completed!: \t \`git push\` ";
    echo "";
fi

if [ "${TO_RUN_DEPLOY_TRIGGER_URL}" == "Y" ]; then
    curl -X POST "${DEPLOYMENT_TRIGGER_URL}";
#        curl --silent --output /dev/null -X POST "${DEPLOYMENT_TRIGGER_URL}";
    echo -e "Deploy To Trigger URL Completed!: \t \`${DEPLOYMENT_TRIGGER_URL}\` ";
    echo "";
fi



if [ "${TO_RUN_ASSETS_MINIFICATION}" == "Y" ]; then
    echo -e "\t ✅ JS/CSS Assets Minified";
else
    echo -e "\t 🚫 JS/CSS Assets Minified";
fi

if [ "${TO_RUN_GIT_ADD}" == "Y" ]; then
    echo -e "\t ✅ Git Add";
else
    echo -e "\t 🚫 Git Add";
fi

if [ "${TO_RUN_GIT_COMMIT}" == "Y" ]; then
    echo -e "\t ✅ Git Commit (Message: \"${GIT_COMMIT_MESSAGE})\"";
else
    echo -e "\t 🚫 Git Commit";
fi

if [ "${TO_RUN_GIT_PUSH}" == "Y" ]; then
    echo -e "\t ✅ Git Push";
else
    echo -e "\t 🚫 Git Push";
fi

if [ "${TO_RUN_DEPLOY_TRIGGER_URL}" == "Y" ]; then
    echo -e "\t ✅ Deploy Trigger URL";
else
    echo -e "\t 🚫 Deploy Trigger URL";
fi

echo "";
exit 0;






# echo "${GIT_COMMIT_MESSAGE}"
# exit 1;



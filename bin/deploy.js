import gcloud from '@battis/partly-gcloudy';
import cli from '@battis/qui-cli';
import path from 'node:path';

(async () => {
  const {
    values: { force }
  } = await gcloud.init({
    env: {
      root: path.dirname(import.meta.dirname)
    },
    args: {
      flags: {
        force: {
          short: 'f',
          default: false
        }
      }
    }
  });

  if (process.env.PROJECT && !force) {
    await gcloud.batch.appEngineDeployAndCleanup({ retainVersions: 2 });
  } else {
    const { project } = await gcloud.batch.appEnginePublish();

    await gcloud.services.enable(gcloud.services.API.CloudFirestoreAPI);
    const [{ name: database }] = JSON.parse(
      cli.shell.exec(
        `gcloud firestore databases list --project=${project.projectId} --format=json --quiet`
      )
    );
    cli.shell.exec(
      `gcloud firestore databases update --type=firestore-native --database="${database}" --project=${project.projectId} --format=json --quiet`
    );

    await gcloud.services.enable(
      gcloud.services.API.CloudMemorystoreforMemcachedAPI
    );
  }
})();

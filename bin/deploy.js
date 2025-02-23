import gcloud from '@battis/partly-gcloudy';
import { Core } from '@battis/qui-cli.core';
import { Shell } from '@battis/qui-cli.shell';
import path from 'node:path';

(async () => {
  Core.configure({ root: { root: path.dirname(import.meta.dirname) } });
  const args = await Core.init({
    flag: {
      force: {
        short: 'f',
        default: false
      }
    }
  });
  const {
    values: { force }
  } = args;

  if (process.env.PROJECT && !force) {
    await gcloud.batch.appEngineDeployAndCleanup({ retainVersions: 2 });
  } else {
    const { project } = await gcloud.batch.appEnginePublish();

    await gcloud.services.enable(gcloud.services.API.CloudFirestoreAPI);
    const [{ name: database }] = JSON.parse(
      Shell.exec(
        `gcloud firestore databases list --project=${project.projectId} --format=json --quiet`
      )
    );
    Shell.exec(
      `gcloud firestore databases update --type=firestore-native --database="${database}" --project=${project.projectId} --format=json --quiet`
    );

    await gcloud.services.enable(
      gcloud.services.API.CloudMemorystoreforMemcachedAPI
    );
  }
})();

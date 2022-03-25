import { Octokit } from "https://cdn.skypack.dev/@octokit/core";
const octokit = new Octokit({ auth: "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" });

var user = '1bengardner';
var repo = 'siftgifts';

var tags;
await octokit.request('GET /repos/{owner}/{repo}/tags', {
  owner: user,
  repo: repo
}).then(allTags => {
  tags = allTags.data;
});

Array.from(document.getElementsByClassName('version-number')).forEach(versionHeading => {
  let ref;
  try {
    ref = tags.find(tag => tag.name == versionHeading.textContent).commit.sha
  } catch {
    console.warn('Github tag not found: '+versionHeading.textContent);
    return;
  }
  octokit.request('GET /repos/{owner}/{repo}/commits/{ref}', {
    owner: user,
    repo: repo,
    ref: ref
  }).then(commit => {
    let date = new Date(commit.data.commit.author.date);
    let format = { month: 'short', day: 'numeric' };
    if (date.getFullYear() < new Date().getFullYear()) {
      format.year = 'numeric';
    }
    versionHeading.nextElementSibling.textContent = date.toLocaleDateString('en-CA', format);
  });
});
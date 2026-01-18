const FEEDS = [
  {
    name: "OpenPhish",
    url: "https://openphish.com/feed.txt"
  },
  {
    name: "URLhaus",
    url: "https://urlhaus.abuse.ch/downloads/text/"
  }
];

async function fetchFeed(feedUrl) {
  const res = await fetch(feedUrl);
  const text = await res.text();
  return text.split("\n").map(l => l.trim()).filter(Boolean);
}

function normalize(url) {
  try {
    const u = new URL(url);
    return `${u.protocol}//${u.hostname}${u.pathname}`;
  } catch {
    return null;
  }
}

async function scanUrl(targetUrl) {
  const normalizedTarget = normalize(targetUrl);
  if (!normalizedTarget) return { safe: true };

  for (const feed of FEEDS) {
    try {
      const list = await fetchFeed(feed.url);
      if (list.includes(normalizedTarget)) {
        return {
          safe: false,
          source: feed.name
        };
      }
    } catch (e) {
      console.error(`Feed error: ${feed.name}`, e);
    }
  }

  return { safe: true };
}

chrome.runtime.onMessage.addListener((msg, sender, sendResponse) => {
  if (msg.type === "SCAN_URL") {
    scanUrl(msg.url).then(sendResponse);
    return true;
  }
});


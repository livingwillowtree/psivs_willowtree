const status = document.getElementById("status");

chrome.tabs.query({ active: true, currentWindow: true }, tabs => {
  const url = tabs[0].url;

  chrome.runtime.sendMessage(
    { type: "SCAN_URL", url },
    result => {
      if (!result) {
        status.textContent = "Scan failed";
        return;
      }

      if (result.safe) {
        status.textContent = "URL appears safe";
        status.className = "safe";
      } else {
        status.textContent = `Malicious (matched ${result.source})`;
        status.className = "danger";
      }
    }
  );
});


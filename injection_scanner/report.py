def generate_html_report(findings, output_file="findings.html"):
    html = """<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vulnerability Scan Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f5f5f5;
        }
        h1 {
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .finding {
            background: #ffffff;
            border-left: 5px solid #c0392b;
            padding: 16px;
            margin-bottom: 20px;
        }
        .label {
            font-weight: bold;
        }
    </style>
</head>
<body>

<h1>Findings</h1>
"""

    for f in findings:
        html += f"""
<div class="finding">
    <p><span class="label">Type:</span> {f['type']}</p>
    <p><span class="label">Vulnerable URL:</span> {f['url']}</p>
    <p><span class="label">Vulnerable Parameter:</span> {f['param']}</p>
    <p><span class="label">Suggestion:</span> {f['suggestion']}</p>
</div>
"""

    html += """
</body>
</html>
"""

    with open(output_file, "w") as f:
        f.write(html)


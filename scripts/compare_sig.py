#!/usr/bin/env python3
import sys, cv2, numpy as np, logging, datetime
from skimage.metrics import structural_similarity as ssim
from pathlib import Path

# ────────── 0. Logging setup ──────────
# Project root = …/proyekAbsensiSmkWil
BASE_DIR = Path(__file__).resolve().parent.parent
LOG_DIR  = BASE_DIR / "storage" / "logs"
LOG_DIR.mkdir(parents=True, exist_ok=True)

log_file = LOG_DIR / f"compare_sig-{datetime.date.today():%Y-%m-%d}.log"
logging.basicConfig(
    filename=str(log_file),
    level=logging.INFO,
    format="%(asctime)s [%(levelname)s] %(message)s",
)
logger = logging.getLogger("compare_sig")

# ────────── 1. Argumen & opsi ──────────
if len(sys.argv) < 3:
    logger.error("Usage: compare_sig.py <img1> <img2> [--debug]")
    sys.exit(1)

IMG1, IMG2 = sys.argv[1], sys.argv[2]
DEBUG      = "--debug" in sys.argv[3:]

logger.info("Comparing\n  • %s\n  • %s", IMG1, IMG2)

# ────────── 2. Helper function ──────────
def load_roi(path, tag=None):
    g = cv2.imread(path, cv2.IMREAD_GRAYSCALE)
    if g is None:
        logger.error("Cannot read %s", path)
        sys.exit(1)

    _, bw = cv2.threshold(g, 0, 255,
                          cv2.THRESH_BINARY_INV + cv2.THRESH_OTSU)

    ys, xs = np.where(bw > 0)
    if len(xs) == 0:
        roi = np.zeros((256, 256), np.uint8)
    else:
        x0, y0, x1, y1 = xs.min(), ys.min(), xs.max(), ys.max()
        roi = bw[y0:y1 + 1, x0:x1 + 1]

        h, w = roi.shape
        scale = 256 / max(h, w)
        roi = cv2.resize(roi, (int(w * scale), int(h * scale)),
                         interpolation=cv2.INTER_NEAREST)

        canvas = np.zeros((256, 256), np.uint8)
        ch, cw = roi.shape
        canvas[(256 - ch) // 2:(256 - ch) // 2 + ch,
               (256 - cw) // 2:(256 - cw) // 2 + cw] = roi
        roi = canvas

    # simpan debug ROI individual
    if DEBUG and tag:
        roi_path = f"debug_roi_{tag}.png"
        cv2.imwrite(roi_path, roi)
        logger.debug("Saved %s", roi_path)

    return roi

def hu_dist(a, b):
    ha = cv2.HuMoments(cv2.moments(a)).flatten()
    hb = cv2.HuMoments(cv2.moments(b)).flatten()
    ha = -np.sign(ha) * np.log10(np.abs(ha) + 1e-10)
    hb = -np.sign(hb) * np.log10(np.abs(hb) + 1e-10)
    return np.linalg.norm(ha - hb)

# ────────── 3. Proses utama ──────────
img1 = load_roi(IMG1, "1")
img2 = load_roi(IMG2, "2")

# simpan gabungan untuk inspeksi visual
if DEBUG:
    side_by_side = np.hstack([img1, img2])
    cv2.imwrite("debug_compare.png", side_by_side)
    logger.debug("Saved debug_compare.png")

score_ssim = ssim(img1, img2)
score_hu   = hu_dist(img1, img2)

logger.info("SSIM=%.4f  HuDist=%.2f", score_ssim, score_hu)

# ────────── 4. Output & exit code ──────────
if score_hu <= 2.0 and score_ssim >= 0.70:
    print("MATCH")               # <-- dibaca Laravel
    sys.exit(0)
else:
    print("NOT_MATCH")
    sys.exit(1)

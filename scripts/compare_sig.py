#!/usr/bin/env python3
import sys, cv2, numpy as np
from skimage.metrics import structural_similarity as ssim

if len(sys.argv) != 3:
    sys.exit("Usage: compare_sig.py <img1> <img2>")

# ---------- helper ----------
def load_roi(path):
    g = cv2.imread(path, cv2.IMREAD_GRAYSCALE)
    if g is None:
        sys.exit(f"Cannot read {path}")
    _, bw = cv2.threshold(g, 0, 255,
                          cv2.THRESH_BINARY_INV + cv2.THRESH_OTSU)

    ys, xs = np.where(bw > 0)
    if len(xs) == 0:
        return np.zeros((256, 256), np.uint8)

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
    return canvas


def hu_dist(a, b):
    ha = cv2.HuMoments(cv2.moments(a)).flatten()
    hb = cv2.HuMoments(cv2.moments(b)).flatten()
    ha = -np.sign(ha) * np.log10(np.abs(ha) + 1e-10)
    hb = -np.sign(hb) * np.log10(np.abs(hb) + 1e-10)
    return np.linalg.norm(ha - hb)


# ---------- main ----------
img1 = load_roi(sys.argv[1])
img2 = load_roi(sys.argv[2])

score_ssim = ssim(img1, img2)
score_hu   = hu_dist(img1, img2)

print(f"SSIM={score_ssim:.4f}  HuDist={score_hu:.2f}")

# aturan final
if score_hu <= 2.0 and score_ssim >= 0.70:
    print("MATCH")
    sys.exit(0)
else:
    print("NOT_MATCH")
    sys.exit(1)

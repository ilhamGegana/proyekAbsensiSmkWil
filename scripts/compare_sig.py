#!/usr/bin/env python3
import sys, cv2
from skimage.metrics import structural_similarity as ssim

if len(sys.argv) != 3:
    sys.exit("Usage: compare_sig.py <img1> <img2>")

# baca & konversi abu-abu
img1 = cv2.imread(sys.argv[1])
img2 = cv2.imread(sys.argv[2])
if img1 is None or img2 is None:
    sys.exit("Cannot read input file(s)")

gray1 = cv2.cvtColor(img1, cv2.COLOR_BGR2GRAY)
gray2 = cv2.cvtColor(img2, cv2.COLOR_BGR2GRAY)

# resize 300×300 seperti repo
gray1 = cv2.resize(gray1, (300, 300))
gray2 = cv2.resize(gray2, (300, 300))

score = ssim(gray1, gray2)
print(f"{score:.4f}")           # 0-1; tambahkan ×100 jika mau persentase

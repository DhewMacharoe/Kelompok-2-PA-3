import json

with open('MachineLearning_02.ipynb', 'r', encoding='utf-8') as f:
    nb = json.load(f)
    
for i, cell in enumerate(nb['cells']):
    if cell['cell_type'] == 'code':
        print("".join(cell['source']).encode('cp1252', errors='replace').decode('cp1252'))
        print(f"====== END CELL {i} ======")

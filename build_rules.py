import json

with open('MachineLearning_02.ipynb', 'r', encoding='utf-8') as f:
    nb = json.load(f)
    
code_to_exec = []
for cell in nb['cells']:
    if cell['cell_type'] == 'code':
        source = "".join(cell['source'])
        if 'adult_male = {' in source or 'adult_female = {' in source or 'teen_male =' in source or 'teen_female =' in source:
            code_to_exec.append(source)

with open('extract_rules.py', 'w', encoding='utf-8') as f:
    f.write("\n".join(code_to_exec))
    f.write("""
rekomendasi_rules = {
    'male': {
        'adult': adult_male,
        'teen': teen_male
    },
    'female': {
        'adult': adult_female,
        'teen': teen_female
    }
}
import json
with open('public/ai_model/rekomendasi_rules.json', 'w') as f:
    json.dump(rekomendasi_rules, f, indent=4)
""")

import os
import re

def extract_operators_and_operands(code):
    operators = re.findall(r'[+\-*/%=<>!&|^~?:]+|\b(function|return|if|else|for|while|switch|case|break|continue|new|var|let|const|class|extends|import|export|try|catch|throw)\b', code)
    operands = re.findall(r'\b[a-zA-Z_][a-zA-Z0-9_]*\b', code)
    return operators, operands

def count_halstead_metrics(directory, extensions):
    operator_count = {}
    operand_count = {}
    
    for root, _, files in os.walk(directory):
        for file in files:
            if file.endswith(extensions):
                file_path = os.path.join(root, file)
                try:
                    with open(file_path, 'r', encoding='utf-8', errors='ignore') as f:
                        code = f.read()
                        operators, operands = extract_operators_and_operands(code)
                        
                        for op in operators:
                            operator_count[op] = operator_count.get(op, 0) + 1
                        
                        for opd in operands:
                            operand_count[opd] = operand_count.get(opd, 0) + 1
                except Exception as e:
                    print(f"Error reading {file_path}: {e}")
    
    # Calculate Halstead Metrics
    n1 = len(operator_count)  # Number of unique operators
    n2 = len(operand_count)   # Number of unique operands
    N1 = sum(operator_count.values())  # Total occurrences of operators
    N2 = sum(operand_count.values())   # Total occurrences of operands
    
    n = n1 + n2  # Vocabulary
    N = N1 + N2  # Length
    V = N * (n1 + n2) if n > 0 else 0  # Volume
    D = (n1 / 2) * (N2 / n2) if n2 > 0 else 0  # Difficulty
    E = D * V  # Effort
    B = V / 3000  # Estimated number of bugs
    
    return {
        "n1 (Unique Operators)": n1,
        "n2 (Unique Operands)": n2,
        "N1 (Total Operators)": N1,
        "N2 (Total Operands)": N2,
        "Vocabulary (n)": n,
        "Length (N)": N,
        "Volume (V)": V,
        "Difficulty (D)": D,
        "Effort (E)": E,
        "Estimated Bugs (B)": B
    }

if __name__ == "__main__":
    project_directory = input("Enter the project directory path: ")
    extensions = (".css", ".js", ".php", ".html")
    results = count_halstead_metrics(project_directory, extensions)
    
    print("\nHalstead Metrics Results:")
    for key, value in results.items():
        print(f"{key}: {value}")
